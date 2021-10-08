<?php

namespace App\Repositories\HomePage;

use App\Logger\Contact\LoggerInterface;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Log;
use App\Models\News;
use App\Models\User;

class NewsRepository
{
    protected $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function getAllPublishNews()
    {
        $news = News::where('published_at', '<', now())->with('author');
        return $news;
    }

    public function getNewsById($id)
    {
        return News::with('Comments')->findOrFail($id);
    }

    public function getAllCategories()
    {
        return  Category::all();
    }

    public function filterNewsByCategory($news,$category_id)
    {
        $news = $news->where('category_id', $category_id);
        return $news;
    }

    public function storecomment($data)
    {
        $this->logger->info('New comment created');
        Comment::create($data);
    }

    public function getCommentById($id)
    {
        return Comment::findOrFail($id);
    }

    public function destroyComment(Comment $comment)
    {
        $this->logger->info('Deleted comment');
        $comment->delete();
    }

    public function filterNewsBySubCategories($subCategArray)
    {
        return News::where('published_at', '<', now())->whereIn('category_id', $subCategArray)->with('author');
    }

    public function getNewsByUserRead($user_id)
    {
        return Log::where('user_id',  $user_id)->where('message', 'like', '%'. 'User open this news'.'%');
    }
}

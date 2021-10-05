<?php

namespace App\Repositories\HomePage;

use App\Models\Category;
use App\Models\Comment;
use App\Models\News;
use App\Models\User;
use function GuzzleHttp\Promise\all;

class NewsRepository
{
    protected $News;

    public function __construct(News $News)
    {
        $this->News = $News;
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
        Comment::create($data);
    }

    public function getCommentById($id)
    {
        return Comment::findOrFail($id);
    }

    public function destroyComment(Comment $comment)
    {
        $comment->delete();
    }
}

<?php

namespace App\Repositories\Editor;

use App\Logger\Contact\LoggerInterface;
use App\Models\Category;
use App\Models\News;
use App\Models\User;

class EditorRepository
{
    protected $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function  getEditorCategories(User $user)
    {
        return $user->categories;
    }

    public function getAllCategories()
    {
        return Category::all();
    }


    public function storenews($data)
    {
        $this->logger->info('New news created');
        News::create($data);
    }

    public function updatenews($data,News $news)
    {
        $this->logger->info('Updated category');
        $news->update($data);
    }

    public function getNewsByAuthorID($id)
    {
        $news = News::with('author')->where('author_id', '=', $id)->get();
        return $news;
    }

    public function getNewsAll()
    {
        $news = News::with('author')->get();
        return $news;
    }

    public function getNewsById($id)
    {
        $news = News::findOrFail($id);
        return $news;
    }

    public function destroyNews(News $news)
    {
        $this->logger->info('Deleted news');
        $news->delete();
    }

}

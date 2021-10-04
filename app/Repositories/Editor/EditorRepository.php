<?php

namespace App\Repositories\Editor;

use App\Models\Category;
use App\Models\News;
use App\Models\User;

class EditorRepository
{
    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function  getEditorCategories(User $user)
    {
        return $user->categories;
    }

    public function getAllCategories()
    {
        return Category::all();
    }

    public function  checkEditorRole(User $Editor)
    {
        return $Editor->hasRole('editor');
    }

    public function storenews($data)
    {
        News::create($data);
    }

    public function updatenews($data,News $news)
    {
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
        $news->delete();
    }

}

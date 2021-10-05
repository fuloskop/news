<?php

namespace App\Business\HomePage;


use App\Repositories\HomePage\NewsRepository;
use function Symfony\Component\Translation\t;

class NewsBusiness
{
    protected $NewsRepository;

    public function __construct(NewsRepository $NewsRepository)
    {
        $this->NewsRepository = $NewsRepository;
    }

    public function getAllPublishNews()
    {
        $news = $this->NewsRepository->getAllPublishNews();
        return $news->paginate(10);
    }

    public function getNewsById($id)
    {
        return $this->NewsRepository->getNewsById($id);
    }

    public function getAllCategories()
    {
        return $this->NewsRepository->getAllCategories();
    }

    public function getAllPublishNewsByCategory($id)
    {
        $news = $this->NewsRepository->getAllPublishNews();
        $news = $this->NewsRepository->filterNewsByCategory($news,$id);
        return $news->paginate(10);
    }

    public function storecomment($data,$user_id)
    {
        $data = array_merge($data, ['user_id' => $user_id]);
        $this->NewsRepository->storecomment($data,$user_id);
    }

    public function getCommentById($id)
    {
        return $this->NewsRepository->getCommentById($id);
    }

    public function destroyCommentById($id)
    {
        $comment = $this->getCommentById($id);
        $this->NewsRepository->destroyComment($comment);

    }
}

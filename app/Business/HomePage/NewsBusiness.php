<?php

namespace App\Business\HomePage;


use App\Models\News;
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
        return $news->latest()->paginate(10);
    }

    public function getNewsById($id)
    {
        return $this->NewsRepository->getNewsById($id);
    }
    public function getNewsByIdWithoutFail($id)
    {
        return $this->NewsRepository->getNewsByIdWithoutFail($id);
    }

    public function getAllCategories()
    {
        return $this->NewsRepository->getAllCategories();
    }

    public function getAllPublishNewsByCategory($id)
    {
        $news = $this->NewsRepository->getAllPublishNews();
        $news = $this->NewsRepository->filterNewsByCategory($news,$id);
        return $news->latest()->paginate(10);
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

    public function getAllPublishNewsBySubCategories($user)
    {
        $subcategoryarray = array();
        foreach ($user->subCategories as $subCategory){
            $subcategoryarray[] = $subCategory->pivot->category_id;
        }
        return $this->NewsRepository->filterNewsBySubCategories($subcategoryarray)->latest()->paginate(10);

    }

    public function getNewsByUserRead($user)
    {
        $logs = $this->NewsRepository->getNewsByUserRead($user->id);
        $newsIdsArray = array();
        foreach ($logs->get() as $log) {
            $newsIdsArray[] = substr(strrchr($log->message, ' '), 1);
        }
        $readedNews = $this->getNewsByIdWithoutFail($newsIdsArray);

        return compact('logs','readedNews');
    }
}

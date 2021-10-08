<?php

namespace App\Business\Editor;

use App\Logger\Contact\LoggerInterface;
use App\Models\News;
use App\Models\User;
use App\Repositories\Editor\EditorRepository;
use Carbon\Carbon;

class EditorBusiness
{
    protected $EditorRepository;
    protected $logger;

    public function __construct(EditorRepository $EditorRepository,LoggerInterface $logger)
    {
        $this->EditorRepository = $EditorRepository;
        $this->logger = $logger;
    }

    public function getEditorCategories($user)
    {
        return $this->EditorRepository->getEditorCategories($user);
    }

    public function getAllCategories()
    {
        return $this->EditorRepository->getAllCategories();
    }

    public function checkNewsCategoriesIsEditorsValidCategory($id,$editorValidCategories)
    {
        return $editorValidCategories->contains('id', $id);
    }

    public function storenews($data,$editor_id)
    {
        $data['body'] = $data['wysiwyg-editor'];
        unset($data['wysiwyg-editor']);
        $data = array_merge($data, ['author_id' => $editor_id]);
        $this->EditorRepository->storenews($data);
    }

    public function updatenews($data,$editor_id,$id)
    {
        $data['body'] = $data['wysiwyg-editor'];
        unset($data['wysiwyg-editor']);
        $data = array_merge($data, ['author_id' => $editor_id]);

        $news =  $this->getNewsById($id);

        $this->EditorRepository->updatenews($data,$news);
    }

    public function getNewsByAuthorID($id)
    {
        return $this->EditorRepository->getNewsByAuthorID($id);
    }

    public function getNewsAll()
    {
        return $this->EditorRepository->getNewsAll();
    }

    public function getNewsById($id)
    {
        return $this->EditorRepository->getNewsById($id);
    }

    public function findDestroyNews($id)
    {
        $news = $this->getNewsById($id);
        $this->EditorRepository->destroyNews($news);
    }

    public function checkNewsEditable(News $news) // eğer published_at null değilse ve 1 günden geç eski değilse haber editlenebilecek.
    {
        if(isset($news->published_at) && Carbon::yesterday() > Carbon::parse($news->published_at) ){
            $this->logger->warning('Unauthorized user detected trying to change old news');
            abort(403,'Haber tarihi eski olduğu için değişiklik yapılamaz veya silinemez. Yöneticinize başvurun.');
            return false;
        }
        return true;
    }
}

<?php

namespace App\Http\Controllers\Editor;

use App\Business\Editor\EditorBusiness;
use App\Logger\Contact\LoggerInterface;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EditorController extends Controller
{

    private $EditorBusiness;
    private $logger;

    public function __construct(EditorBusiness $EditorBusiness,LoggerInterface $logger)
    {
        $this->EditorBusiness = $EditorBusiness;
        $this->logger = $logger;
    }


    public function getEditorPanel()
    {
        $this->logger->activity('Access editor panel');
        return view('frontend.EditorPanel.EditorPanel');
    }

    public function createnews()
    {
        $this->logger->activity('Access editor panel new create page');
        $user = auth()->user();

        $AvailableCategories = $this->EditorBusiness->getAllCategories(); // tüm kategorileri getir eğer aşağıda editörlüğü doğrulanmazsa diye

        if(!$user->hasPermissionTo('create news without category')){ //$user->hasRole('editor')
            $AvailableCategories = $this->EditorBusiness->getEditorCategories($user);
        }

        return view('frontend.EditorPanel.CreateNews',compact('AvailableCategories'));
    }

    public function storenews(Request $request)
    {
        $validated = $request->validate([
            'published_at' => 'nullable|date',
            'title' => 'required|string',
            'wysiwyg-editor' => 'required|string',
            'category_id' => 'required|exists:categories,id',
        ]);
        $this->logger->activity('Access editor panel save new news');

        $Editor = auth()->user();
        if(!$Editor->hasPermissionTo('create news without category')){
            $EditorCategories = $this->EditorBusiness->getEditorCategories($Editor);
            if(!$this->EditorBusiness->checkNewsCategoriesIsEditorsValidCategory($request->category_id,$EditorCategories)){
                $this->logger->warning('Editor detected trying to create news in unauthorized category');
                abort(403);
            }
        }

        $this->EditorBusiness->storenews($request->only('published_at','title','wysiwyg-editor','category_id'),$Editor->id);


        return redirect()->route('Editor.indexnews');
    }

    public function indexnews()
    {
        $this->logger->activity('Access editor panel news list');
        $User = auth()->user();
        if($User->hasPermissionTo('access all news')){
            $news = $this->EditorBusiness->getNewsAll();
            // News::with('author')->get();
            return view('frontend.EditorPanel.IndexNews',compact('news'));
        }
        $news = $this->EditorBusiness->getNewsByAuthorID($User->id);
        return view('frontend.EditorPanel.IndexNews',compact('news'));
    }

    public function editnews($id)
    {
        $this->logger->activity('Access editor panel edit news');
        $news = $this->EditorBusiness->getNewsById($id);

        $User = auth()->user();

        if(!$User->hasPermissionTo('manage old news')){ // tarihi geçen haber silmek için admin yetkisi gerekir.
            $this->EditorBusiness->checkNewsEditable($news);
        }


        if($User->hasRole('editor') && $User->id == $news->author_id){
            $Categories = $this->EditorBusiness->getEditorCategories($User);
            return view('frontend.EditorPanel.EditNews',compact('news','Categories'));

        }elseif ($User->hasPermissionTo('access all categories')) {
            $Categories = $this->EditorBusiness->getAllCategories();
            return view('frontend.EditorPanel.EditNews',compact('news','Categories'));
        }
        $this->logger->warning('Unauthorized user detected trying to change news');
        abort(403);
    }

    public function updatenews(Request $request, $id)
    {
        $validated = $request->validate([
            'published_at' => 'nullable|date',
            'title' => 'required|string',
            'wysiwyg-editor' => 'required|string',
            'category_id' => 'required|exists:categories,id',
        ]);

        $this->logger->activity('Access editor panel update news');

        $user = auth()->user();
        if($user->hasPermissionTo('access all news')){
            $Author_id = $request->author_id;
        }

        if(!$user->hasPermissionTo('manage old news')){ // tarihi geçen haber silmek veya değiştirmek için admin yetkisi gerekir.
            $this->EditorBusiness->checkNewsEditable($this->EditorBusiness->getNewsById($id));
        }

        if(!$user->hasPermissionTo('access all news')){
            $Author_id = $user->id;
            $EditorCategories = $this->EditorBusiness->getEditorCategories($user);
            if(!$this->EditorBusiness->checkNewsCategoriesIsEditorsValidCategory($request->category_id,$EditorCategories)){
                $this->logger->warning('Editor detected trying to create news in unauthorized category');
                abort(403); //yetkisiz kategori denemesi
            }
        }

        $this->EditorBusiness->updatenews($request->only('published_at','title','wysiwyg-editor','category_id'),$Author_id,$id);
        return redirect()->route('Editor.indexnews');
    }

    public function destroyNews($id)
    {
        $User = auth()->user();
        if(!$User->hasPermissionTo('manage old news')){ // tarihi geçen haber silmek için admin yetkisi gerekir.
            $this->EditorBusiness->checkNewsEditable($this->EditorBusiness->getNewsById($id));
        }
        $this->EditorBusiness->findDestroyNews($id);
        return redirect()->route('Editor.indexnews');
    }
}

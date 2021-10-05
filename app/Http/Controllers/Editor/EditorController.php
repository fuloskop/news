<?php

namespace App\Http\Controllers\Editor;

use App\Business\Editor\EditorBusiness;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EditorController extends Controller
{

    private $EditorBusiness;

    public function __construct(EditorBusiness $EditorBusiness)
    {
        $this->EditorBusiness = $EditorBusiness;
    }


    public function getEditorPanel()
    {
        return view('frontend.EditorPanel.EditorPanel');
    }

    public function createnews()
    {
        $user = auth()->user();

        $AvailableCategories = $this->EditorBusiness->getAllCategories(); // tüm kategorileri getir eğer aşağıda editörlüğü doğrulanmazsa diye

        if($this->EditorBusiness->isValidEditor($user)){ //$user->hasRole('editor')
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

        $Editor = auth()->user();
        if($Editor->hasRole('editor')){
            $EditorCategories = $this->EditorBusiness->getEditorCategories($Editor);
            if(!$this->EditorBusiness->checkNewsCategoriesIsEditorsValidCategory($request->category_id,$EditorCategories)){
                abort(403);
            }
        }
        $this->EditorBusiness->storenews($request->only('published_at','title','wysiwyg-editor','category_id'),$Editor->id);


        return redirect()->route('Editor.indexnews');
    }

    public function indexnews()
    {
        $User = auth()->user();
        if($User->hasAnyRole(['admin', 'moderator'])){
            $news = $this->EditorBusiness->getNewsAll();
            // News::with('author')->get();
            return view('frontend.EditorPanel.IndexNews',compact('news'));
        }
        $news = $this->EditorBusiness->getNewsByAuthorID($User->id);
        return view('frontend.EditorPanel.IndexNews',compact('news'));
    }

    public function editnews($id)
    {
        $news = $this->EditorBusiness->getNewsById($id);

        $User = auth()->user();

        if(!$User->hasRole('admin')){ // tarihi geçen haber silmek için admin yetkisi gerekir.
            $this->EditorBusiness->checkNewsEditable($news);
        }


        if($User->hasRole('editor') && $User->id == $news->author_id){
            $Categories = $this->EditorBusiness->getEditorCategories($User);
            return view('frontend.EditorPanel.EditNews',compact('news','Categories'));

        }elseif ($User->hasAnyRole(['admin', 'moderator'])) {
            $Categories = $this->EditorBusiness->getAllCategories();
            return view('frontend.EditorPanel.EditNews',compact('news','Categories'));
        }
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

        $user = auth()->user();
        if($user->hasAnyRole(['admin', 'moderator'])){
            $Author_id = $request->author_id;
        }

        if(!$user->hasRole('admin')){ // tarihi geçen haber silmek veya değiştirmek için admin yetkisi gerekir.
            $this->EditorBusiness->checkNewsEditable($this->EditorBusiness->getNewsById($id));
        }

        if($user->hasRole('editor')){
            $Author_id = $user->id;
            $EditorCategories = $this->EditorBusiness->getEditorCategories($user);
            if(!$this->EditorBusiness->checkNewsCategoriesIsEditorsValidCategory($request->category_id,$EditorCategories)){
                abort(403); //yetkisiz kategori denemesi
            }
        }

        $this->EditorBusiness->updatenews($request->only('published_at','title','wysiwyg-editor','category_id'),$Author_id,$id);
        return redirect()->route('Editor.indexnews');
    }

    public function destroyNews($id)
    {
        $User = auth()->user();
        if(!$User->hasRole('admin')){ // tarihi geçen haber silmek için admin yetkisi gerekir.
            $this->EditorBusiness->checkNewsEditable($this->EditorBusiness->getNewsById($id));
        }
        $this->EditorBusiness->findDestroyNews($id);
        return redirect()->route('Editor.indexnews');
    }
}

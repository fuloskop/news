<?php

namespace App\Http\Controllers\Editor;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EditorController extends Controller
{
    public function getEditorPanel()
    {
        return view('frontend.EditorPanel.EditorPanel');
    }

    public function createnews()
    {
        $AvailableCategories = auth()->user()->categories; //ControllerBusinessRepo Mantığına getirilecek
        return view('frontend.EditorPanel.CreateNews',compact('AvailableCategories'));
    }

    public function storenews(Request $request)
    {
        //route eklenmedi eklenecen /editor/createnews sayfası tamamlanmadı tamamlanacak
        //return $request->all();
    }
}

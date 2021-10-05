<?php

namespace App\Http\Controllers\HomePage;

use Illuminate\Http\Request;
use App\Business\HomePage\NewsBusiness;
use App\Http\Controllers\Controller;

class NewsController extends Controller
{
    private $NewsBusiness;

    public function __construct(NewsBusiness $NewsBusiness)
    {
        $this->NewsBusiness = $NewsBusiness;
    }

    public function getAllPublishNews()
    {
        $news = $this->NewsBusiness->getAllPublishNews();
        return view('frontend.HomePage.IndexNews',compact('news'));
    }

    public function getNewsById($id)
    {
        $news = $this->NewsBusiness->getNewsById($id);
        return view('frontend.HomePage.ShowNews',compact('news'));
    }

    public function getAllCategories()
    {
        $categories = $this->NewsBusiness->getAllCategories();
        return view('frontend.HomePage.IndexCategories',compact('categories'));
    }

    public function getNewsByCategoryId($category_Id)
    {
        $news = $this->NewsBusiness->getAllPublishNewsByCategory($category_Id);

        return view('frontend.HomePage.IndexNews',compact('news'));
    }
}

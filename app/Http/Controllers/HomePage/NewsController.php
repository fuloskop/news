<?php

namespace App\Http\Controllers\HomePage;

use App\Logger\Contact\LoggerInterface;
use Illuminate\Http\Request;
use App\Business\HomePage\NewsBusiness;
use App\Http\Controllers\Controller;

class NewsController extends Controller
{
    private $NewsBusiness;
    private $logger;

    public function __construct(NewsBusiness $NewsBusiness,LoggerInterface $logger)
    {
        $this->NewsBusiness = $NewsBusiness;
        $this->logger = $logger;
    }

    public function getAllPublishNews()
    {
        $this->logger->activity("User open all news");
        $news = $this->NewsBusiness->getAllPublishNews();
        return view('frontend.HomePage.IndexNews',compact('news'));
    }

    public function getNewsById($id)
    {
        $this->logger->activity("User open this news $id");
        $news = $this->NewsBusiness->getNewsById($id);
        return view('frontend.HomePage.ShowNews',compact('news'));
    }

    public function getAllCategories()
    {
        $this->logger->activity("User open all news categories");
        $categories = $this->NewsBusiness->getAllCategories();
        return view('frontend.HomePage.IndexCategories',compact('categories'));
    }

    public function getNewsByCategoryId($category_Id)
    {
        $this->logger->activity("User open all news from this category id $category_Id");
        $news = $this->NewsBusiness->getAllPublishNewsByCategory($category_Id);

        return view('frontend.HomePage.IndexNews',compact('news'));
    }
}

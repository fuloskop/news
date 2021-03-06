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
        $userSubCategories = auth()->user()->subCategories;
        $categories = $this->NewsBusiness->getAllCategories();
        return view('frontend.HomePage.IndexCategories',compact('categories','userSubCategories'));
    }

    public function getNewsByCategoryId($category_Id)
    {
        $this->logger->activity("User open all news from this category id $category_Id");
        $news = $this->NewsBusiness->getAllPublishNewsByCategory($category_Id);

        return view('frontend.HomePage.IndexNews',compact('news'));
    }

    public function getNewsBySubCategories()
    {
        $user = auth()->user();
        $this->logger->activity("User open all news special flow");
        $news = $this->NewsBusiness->getAllPublishNewsBySubCategories($user);

        return view('frontend.HomePage.IndexNews',compact('news'));
    }

    public function getNewsByUserRead()
    {
        $user = auth()->user();
        $this->logger->activity("User opened the page of the news he or she read");

        $data = $this->NewsBusiness->getNewsByUserRead($user);
        $logs = $data['logs'];
        $readedNews = $data['readedNews'];

        $logs = $logs->latest()->paginate(10);

        return view('frontend.HomePage.IndexOldNews',compact('logs','readedNews'));
    }
}

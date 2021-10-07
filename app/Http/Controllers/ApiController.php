<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\News;
use App\Models\User;
use App\Repositories\HomePage\NewsRepository;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    protected $NewsRepository;

    public function __construct(NewsRepository $NewsRepository)
    {
        $this->NewsRepository = $NewsRepository;
    }

    public function tokenCheck(Request $request)
    {
        if (User::where('api_token', $request->bearerToken())->first()) {
            return true;
        } else {
            return false;
        }
    }

    public function getNews(Request $request)
    {
        if ($this->tokenCheck($request)) {
            if ($request->input('category')) {
                $category = Category::where('name', $request->input('category'))->first();
                $data = News::where('published_at', '<', now())->where('category_id', $category->id)->get();
            } else {
                $data = News::where('published_at', '<', now())->get();
            }
            return response()->json(['status' => true, 'data' => $data], 200, []);
        } else {
            return response()->json(['status' => false, 'message' => 'token verification failed.'], 400, []);
        }
    }

    public function getNewsDetail(Request $request)
    {
        if ($this->tokenCheck($request)) {
            if ($request->input('id')) {
                $data = News::find($request->input('id'))->with('Author')->with('Category')->with('Comments')->first();
                return response()->json(['status' => true, 'data' => $data], 200, []);
            } else {
                return response()->json(['status' => false, 'message' => 'id field needed.'], 400, []);
            }
        } else {
            return response()->json(['status' => false, 'message' => 'token verification failed.'], 400, []);
        }
    }
}

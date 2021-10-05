<?php

namespace App\Http\Controllers\HomePage;

use App\Business\HomePage\NewsBusiness;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CommentController extends Controller
{
    private $NewsBusiness;

    public function __construct(NewsBusiness $NewsBusiness)
    {
        $this->NewsBusiness = $NewsBusiness;
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'is_hidden' => 'nullable|boolean',
            'body' => 'required|string',
            'news_id' => 'required|exists:news,id',
        ]);
        $user = auth()->user();
        $this->NewsBusiness->storecomment($request->only('is_hidden','body','news_id'),$user->id);

        return redirect()->route('News.show',$request->news_id);
    }

    public function destroy($id)
    {
        $comment = $this->NewsBusiness->getCommentById($id);
        $user = auth()->user();

        if($comment->user_id == $user->id || $user->hasAnyRole(['admin', 'moderator'])){
            $this->NewsBusiness->destroyCommentById($id);
        }
        abort(403,'Yorumu silmek için gerekli yetkilere sahip değilsiniz.');
    }
}

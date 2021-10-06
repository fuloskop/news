<?php

namespace App\Http\Controllers\HomePage;

use App\Business\HomePage\NewsBusiness;
use App\Logger\Contact\LoggerInterface;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CommentController extends Controller
{
    private $NewsBusiness;
    private $logger;

    public function __construct(NewsBusiness $NewsBusiness,LoggerInterface $logger)
    {
        $this->NewsBusiness = $NewsBusiness;
        $this->logger = $logger;
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'is_hidden' => 'nullable|boolean',
            'body' => 'required|string',
            'news_id' => 'required|exists:news,id',
        ]);
        $this->logger->activity("User create new comment for this news $request->news_id");

        $user = auth()->user();
        $this->NewsBusiness->storecomment($request->only('is_hidden','body','news_id'),$user->id);

        return redirect()->route('News.show',$request->news_id);
    }

    public function destroy($id)
    {
        $comment = $this->NewsBusiness->getCommentById($id);
        $user = auth()->user();

        if($comment->user_id == $user->id || $user->hasAnyRole(['admin', 'moderator'])){
            $this->logger->activity("delete comment form this user $comment->user_id");
            $this->NewsBusiness->destroyCommentById($id);
        }
        abort(403,'Yorumu silmek için gerekli yetkilere sahip değilsiniz.');
    }
}

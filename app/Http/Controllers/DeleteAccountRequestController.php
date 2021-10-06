<?php

namespace App\Http\Controllers;

use App\Logger\Contact\LoggerInterface;
use App\Models\DeleteAccountRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DeleteAccountRequestController extends Controller
{

    protected $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function create()
    {
        $this->logger->activity('User open Delete Account Request page');
        return view('frontend.delaccount');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'body' => 'required|string|max:150',
        ]);

        $this->logger->activity('User create or update Delete Account Request');

        $newreq = DeleteAccountRequest::updateOrCreate([
            'user_id'   => Auth::user()->id,
            ]
            ,
            [
            'request_status' => 'waiting',
            'body' => $request->body,
        ]);

        return redirect('delaccount')->with('success', 'Talebiniz başarılı bir şekilde oluşturuldu veya güncellendi.');
    }
}

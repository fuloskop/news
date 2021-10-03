<?php

namespace App\Http\Controllers\Admin;

use App\Business\Admin\AdminBusiness;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    private $AdminBusiness;

    public function __construct(AdminBusiness $AdminBusiness)
    {
        $this->AdminBusiness = $AdminBusiness;
    }
    public function getAdminPanel()
    {
        return view('frontend.AdminPanel.AdminPanel');
    }

    public function changeRoles()
    {
        $users = $this->AdminBusiness->getAllUsers();
        return view('frontend.AdminPanel.AdminRoles',compact('users'));
    }

    public function indexCategory()
    {
        $categories = $this->AdminBusiness->getAllCategories();
        return view('frontend.AdminPanel.AdminIndexCategory', compact('categories'));
    }

    public function createCategory()
    {
        return view('frontend.AdminPanel.AdminCreateCategory');
    }

    public function storeCategory(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
        ]);

        $this->AdminBusiness->storeOrUpdateCategory($request->only('name'));
        return redirect()->route('Category.index');
    }

    public function editCategory($id)
    {
        $category = $this->AdminBusiness->getCategoryById($id);
        return view('frontend.AdminPanel.AdminCreateCategory',compact('category'));
    }

    public function updateCategory(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string',
        ]);
        $this->AdminBusiness->getCategoryById($id);
        $this->AdminBusiness->storeOrUpdateCategory($request->only('name'), $id);

        return redirect()->route('Category.index');
    }

    public function destroyCategory($id)
    {
        $this->AdminBusiness->destroyCategotyById($id);
        return redirect()->route('Category.index');
    }

    public function updateRoles(Request $request)
    {

        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'added' => 'required|boolean',
            'roletype' => 'required|in:admin,moderator,editor',
        ]);

        if(auth()->user()->hasRole('moderator') && $request->roletype!='editor'){
            return $result = [
                'status' => 403,
                'error' => 'Yetkisiz işlem denemesi.'
            ];
        }

        $result = ['status' => 200];
        try {
            $user = $this->AdminBusiness->getUsersById($request->user_id);
            if ($request->added==1) {
                $user->assignRole($request->roletype);
            } else {
                $user->removeRole($request->roletype);
                $user->categories()->detach();
            }
        }catch (Exception $e) {
            $result = [
                'status' => 500,
                'error' => $e->getMessage(),
                'test'=>$request->all()
            ];
        }

        return response()->json($result,$result['status']);
    }

    public function AdminAcctDelReqIndex()
    {
        $DeleteAccountRequests = $this->AdminBusiness->getAllAccountDeleteRequest();
        return view('frontend.AdminPanel.AdminAcctDelReq',compact('DeleteAccountRequests'));
    }

    public function AdminAcctDelReqShow($id)
    {
        /*
        $ForValidation = ['id' => $id,];
        $validator = Validator::make($ForValidation, ['id' => 'required|exists:delete_account_requests,id']);
        */

        $DeleteAccountRequest = $this->AdminBusiness->getAccountDeleteRequestById($id);
        return view('frontend.AdminPanel.AdminAcctDelReqShow',compact('DeleteAccountRequest'));
    }

    public function AdminAcctDelReqUpdate(Request $request,$id)
    {
        $validated = $request->validate([
            'answer' => 'nullable|string|max:150',
            'request_status' => 'required|in:accepted,denied',
        ]);

        $this->AdminBusiness->getAccountDeleteRequestEnd($request->only('answer','request_status'),$id);
        return redirect()->route('AdminAcctDelReqIndex');
    }

    public function getAdminChangeEditorCategoriesPage()
    {
        $AllEditors = $this->AdminBusiness->getAllEditorUsers();
        return view('frontend.AdminPanel.AdminChangeEditorCategoriesPage',compact('AllEditors'));
    }

    public function AdminChangeEditorCategoriesShow($id)
    {
        $user = $this->AdminBusiness->getUsersById($id);
        if($this->AdminBusiness->isEditor($user)){
            $AllCategories = $this->AdminBusiness->getAllCategories();

            return view('frontend.AdminPanel.AdminChangeEditorCategoriesShow',compact('user','AllCategories'));
        }
        abort(404);

    }

    public function setEditorCategory(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'added' => 'required|boolean',
            'category_id' => 'required|exists:categories,id',
        ]);

        if(!auth()->user()->hasRole('moderator') && !auth()->user()->hasRole('admin')){
            return $result = [
                'status' => 403,
                'error' => 'Yetkisiz işlem denemesi.'
            ];
        }

        $result = ['status' => 200];
        try {
            $user = $this->AdminBusiness->getUsersById($request->user_id);
            if ($request->added==1) {
                $user->categories()->attach($request->category_id);
            } else {
                $user->categories()->detach($request->category_id);
            }
        }catch (Exception $e) {
            $result = [
                'status' => 500,
                'error' => $e->getMessage(),
                'test'=>$request->all()
            ];
        }

        return response()->json($result,$result['status']);
    }


}

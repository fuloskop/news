<?php

namespace App\Http\Controllers\Admin;

use App\Business\Admin\AdminBusiness;
use App\Logger\Contact\LoggerInterface;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    private $AdminBusiness;
    private $logger;

    public function __construct(AdminBusiness $AdminBusiness,LoggerInterface $logger)
    {
        $this->AdminBusiness = $AdminBusiness;
        $this->logger = $logger;
    }
    public function getAdminPanel()
    {
        $this->logger->activity('Access admin panel');
        return view('frontend.AdminPanel.AdminPanel');
    }

    public function changeRoles()
    {
        $this->logger->activity('Access admin panel role page');
        $users = $this->AdminBusiness->getAllUsers();
        return view('frontend.AdminPanel.AdminRoles',compact('users'));
    }

    public function indexCategory()
    {
        $this->logger->activity('Access admin panel categories page');
        $categories = $this->AdminBusiness->getAllCategories();
        return view('frontend.AdminPanel.AdminIndexCategory', compact('categories'));
    }

    public function createCategory()
    {
        $this->logger->activity('Access admin panel new category page');
        return view('frontend.AdminPanel.AdminCreateCategory');
    }

    public function storeCategory(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
        ]);
        $this->logger->activity('Access admin panel save new category');

        $this->AdminBusiness->storeOrUpdateCategory($request->only('name'));


        return redirect()->route('Category.index');
    }

    public function editCategory($id)
    {
        $this->logger->activity('Access admin panel edit category page');
        $category = $this->AdminBusiness->getCategoryById($id);
        return view('frontend.AdminPanel.AdminCreateCategory',compact('category'));
    }

    public function updateCategory(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string',
        ]);
        $this->logger->activity('Access admin panel update category');
        //$this->AdminBusiness->getCategoryById($id);
        $this->AdminBusiness->storeOrUpdateCategory($request->only('name'), $id);

        return redirect()->route('Category.index');
    }

    public function destroyCategory($id)
    {
        $this->logger->activity('Access admin panel delete category');
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

        $this->logger->activity('Access admin panel update roles api');

        if(!auth()->user()->hasPermissionTo('give admin and moderator permission') && $request->roletype!='editor'){
            $this->logger->warning('Unauthorized user detected trying to change role');
            return [
                'status' => 403,
                'error' => 'Yetkisiz işlem denemesi.'
            ];
        }

        $result = ['status' => 200];
        try {
            if ($request->added==1) {
                $this->AdminBusiness->assignRole($request->user_id,$request->roletype);

            } else {
                $this->AdminBusiness->removeRole($request->user_id,$request->roletype);

            }
        }catch (Exception $e) {
            $this->logger->error('An error occurred while switching roles');
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
        $this->logger->activity('Access admin panel index account delete requests');
        $DeleteAccountRequests = $this->AdminBusiness->getAllAccountDeleteRequest();
        return view('frontend.AdminPanel.AdminAcctDelReq',compact('DeleteAccountRequests'));
    }

    public function AdminAcctDelReqShow($id)
    {
        /*
        $ForValidation = ['id' => $id,];
        $validator = Validator::make($ForValidation, ['id' => 'required|exists:delete_account_requests,id']);
        */
        $this->logger->activity('Access admin panel show account delete request');
        $DeleteAccountRequest = $this->AdminBusiness->getAccountDeleteRequestById($id);
        if($DeleteAccountRequest->request_status=="accepted"){
            $this->logger->error("Tried to open the terminated request");
            return back()->withErrors('Bu talep sonlandırılmıştır.');
        }
        return view('frontend.AdminPanel.AdminAcctDelReqShow',compact('DeleteAccountRequest'));
    }

    public function AdminAcctDelReqUpdate(Request $request,$id)
    {
        $validated = $request->validate([
            'answer' => 'nullable|string|max:150',
            'request_status' => 'required|in:accepted,denied',
        ]);
        $this->logger->activity("Access admin panel update account delete request");
        $this->AdminBusiness->getAccountDeleteRequestEnd($request->only('answer','request_status'),$id);
        return redirect()->route('AdminAcctDelReqIndex');
    }

    public function getAdminChangeEditorCategoriesPage()
    {
        $this->logger->activity("Access admin panel editors caregories page");
        $AllEditors = $this->AdminBusiness->getAllEditorUsers();
        return view('frontend.AdminPanel.AdminChangeEditorCategoriesPage',compact('AllEditors'));
    }

    public function AdminChangeEditorCategoriesShow($id)
    {
        $this->logger->activity("Access admin panel editor caregories page");
        $user = $this->AdminBusiness->getUsersById($id);
        if(!$user->hasRole('editor')){
            $this->logger->warning('Unauthorized user detected trying to access editor categories change page ');
            abort(404);
        }
        $AllCategories = $this->AdminBusiness->getAllCategories();

        return view('frontend.AdminPanel.AdminChangeEditorCategoriesShow',compact('user','AllCategories'));
    }

    public function setEditorCategory(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'added' => 'required|boolean',
            'category_id' => 'required|exists:categories,id',
        ]);

        $this->logger->activity('Access admin panel update editor category api');

        if(!auth()->user()->hasPermissionTo('manage editor categories')){
            $this->logger->warning('Unauthorized user detected trying to change editor category');
            return [
                'status' => 403,
                'error' => 'Yetkisiz işlem denemesi.'
            ];
        }

        $result = ['status' => 200];
        try {
            if ($request->added==1) {
                $this->AdminBusiness->assignCategory($request->user_id,$request->category_id);
                //$user->categories()->attach($request->category_id);
            } else {
                $this->AdminBusiness->removeCategory($request->user_id,$request->category_id);
                //$user->categories()->detach($request->category_id);
            }
        }catch (Exception $e) {
            $this->logger->error('An error occurred while switching editor category');
            $result = [
                'status' => 500,
                'error' => $e->getMessage(),
                'test'=>$request->all()
            ];
        }

        return response()->json($result,$result['status']);
    }

    public function getAllLogs()
    {
        $logs = $this->AdminBusiness->getAllLogs()->paginate(10);
        return view('frontend.AdminPanel.AdminIndexLogs',compact('logs'));
    }

    public function getAllActivities()
    {
        $activities = $this->AdminBusiness->getAllActivities();
        return view('frontend.AdminPanel.AdminIndexActivities',compact('activities'));
    }
}

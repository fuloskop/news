<?php

namespace App\Repositories\Admin;

use App\Logger\Contact\LoggerInterface;
use App\Models\Category;
use App\Models\DeleteAccountRequest;
use App\Models\Log;
use App\Models\User;

class AdminRepository
{
    protected $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function getAllUsers()
    {
        return User::all();
    }

    public function getAllAccountDeleteRequest()
    {
        return DeleteAccountRequest::all();
    }

    public function getUsersById($id)
    {

        return User::findOrFail($id);
    }

    public function getAccountDeleteRequestById($id)
    {
        return DeleteAccountRequest::findOrFail($id);
    }

    public function getAccountDeleteRequestEnd(DeleteAccountRequest $RequestToEnded,$data)
    {
        $this->logger->info('Updated Delete Account Request');
        $RequestToEnded->update($data);
    }

    public function DestroyUser(User $user)
    {
        $this->logger->info("User $user->username deleted");
        $user->delete();
    }

    public function getAllEditorUsers()
    {
        return User::role('editor')->get();
    }

    public function getAllCategories()
    {
        return Category::all();
    }

    public function storeOrUpdateCategory($data,&$id=null)
    {
        if(!isset($id)){
            $this->logger->info('New category created');
        }else{
            $this->logger->info('Updated category');
        }

        Category::updateOrCreate([
                'id'   => $id,
            ]
            ,
            [
                'name' => $data['name'],
            ]);
    }

    public function getCategoryById($id)
    {
        return $category = Category::findOrFail($id);
    }

    public function DestroyCategory(Category $category)
    {
        $this->logger->info('Deleted category');
        $category->delete();
    }

    public function assignRole(User $user,$role)
    {
        $this->logger->info("Assing role $role to $user->username ");
        $user->assignRole($role);
    }

    public function removeRole(User $user,$role)
    {
        $this->logger->info("Remove role $role to $user->username ");
        $user->removeRole($role);
    }

    public function detachCategories(User $user)
    {
        $this->logger->info("Remove all category access from $user->username");
        $user->categories()->detach();
    }

    public function attachCategory(User $user,$category_id)
    {
        $this->logger->info("Assing category id $category_id to $user->username");
        $user->categories()->attach($category_id);
    }

    public function detachCategory(User $user,$category_id)
    {
        $this->logger->info("Remove category id $category_id to $user->username");
        $user->categories()->detach($category_id);
    }

    public function getAllLogs()
    {
        return Log::latest();
    }

    public function getAllActivities()
    {
        if (auth()->user()->hasRole('admin')) {
            return Log::where('status', 'activity');
        } else if (auth()->user()->hasRole('moderator')) {
            return Log::where('status' , 'activity')->whereIn('role_type', ['user', 'editor']);
        }
    }
}

<?php

namespace App\Http\Controllers\HomePage;

use App\Business\HomePage\SubCategoryBusiness;
use App\Http\Controllers\Controller;
use App\Logger\Contact\LoggerInterface;
use Illuminate\Http\Request;

class SubCategoryController extends Controller
{
    private $subCategoryBusiness;
    private $logger;

    public function __construct(SubCategoryBusiness $subCategoryBusiness,LoggerInterface $logger)
    {
        $this->subCategoryBusiness = $subCategoryBusiness;
        $this->logger = $logger;
    }

    public function updateSubCategory(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'added' => 'required|boolean',
        ]);

        $user = auth()->user();

        $this->logger->activity('User access change Subscription category api');

        $result = ['status' => 200];
        try {
            if ($request->added==1) {
                $this->subCategoryBusiness->assignSubCategory($user,$request->category_id);

            } else {
                $this->subCategoryBusiness->removeSubCategory($user,$request->category_id);

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


        return $request->all();
    }
}

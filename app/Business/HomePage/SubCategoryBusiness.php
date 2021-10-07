<?php

namespace App\Business\HomePage;

use App\Models\User;
use App\Repositories\HomePage\SubCategoryRepository;


class SubCategoryBusiness
{
    protected $subCategoryRepository;
    protected $logger;

    public function __construct(SubCategoryRepository $subCategoryRepository)
    {
        $this->subCategoryRepository = $subCategoryRepository;
    }

    public function assignSubCategory(User $user,$category_id)
    {
        $this->subCategoryRepository->attachSubCategory($user,$category_id);
    }

    public function removeSubCategory(User $user,$category_id)
    {
        $this->subCategoryRepository->detachSubCategory($user,$category_id);
    }


}

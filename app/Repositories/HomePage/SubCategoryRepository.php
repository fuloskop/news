<?php

namespace App\Repositories\HomePage;

use App\Logger\Contact\LoggerInterface;
use App\Models\User;

class SubCategoryRepository
{
    protected $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function attachSubCategory(User $user,$category_id)
    {
        $this->logger->info("Subscription category id $category_id to $user->username");
        $user->subCategories()->attach($category_id);
    }

    public function detachSubCategory(User $user,$category_id)
    {
        $this->logger->info("Unsubscription category id $category_id to $user->username");
        $user->subCategories()->detach($category_id);
    }

}

<?php declare(strict_types=1);

namespace Wishlistv2\Service;

use DateTime;
use Shopware\Core\Framework\Context;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Criteria;
use Shopware\Core\Framework\DataAbstractionLayer\EntityRepository;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Filter\EqualsFilter;


class WishlistService 
{   
    public $wishlistRepository;

    public function __construct(EntityRepository  $wishlistRepository)
    {
        $this->wishlistRepository = $wishlistRepository; 
    }

    //Function checks if there us a product in wishlist 
    public function isProductInWishlist(string $userId, string $productId, Context $context): bool
    {
    $criteria = new Criteria();
    $criteria->addFilter(new EqualsFilter('userId', $userId));
    $criteria->addFilter(new EqualsFilter('productId', $productId));
   
    $wishlistItems = $this->wishlistRepository->search($criteria, $context)->getTotal();
    
   
    //Array wishlist total will be greater than 0 if item is present
    return $wishlistItems > 0;
    }



    public function addToUserWishlist(string $userId, string $productId, Context $context): void
    {
        $criteria = new Criteria();
        $criteria->addFilter(new EqualsFilter('userId', $userId));
        $criteria->addFilter(new EqualsFilter('productId', $productId));

         $data = [
                [
                    
                    'productId' => $productId,
                    'userId' => $userId,
                    'updatedAt' => new DateTime(),
                    'createdAt' => new DateTime()
                ]
            ];
    
            // Use the repository to create the entity in the database
            $this->wishlistRepository->create($data, $context);

        
    }


    public function removeFromUserWishlist(string $userId, string $productId, Context $context): void
    {
        $criteria = new Criteria();
        $criteria->addFilter(new EqualsFilter('userId', $userId));
        $criteria->addFilter(new EqualsFilter('productId', $productId));
    
        $wishlistItems = $this->wishlistRepository->search($criteria, $context)->getEntities();
    
        foreach ($wishlistItems as $wishlistItem) {
            $this->wishlistRepository->delete([['id' => $wishlistItem->id]], $context);
        }
        
    }

    public function remove(string $productId, Context $context): void
    {
    $criteria = new Criteria();
    $criteria->addFilter(new EqualsFilter('productId', $productId));

    $wishlistItems = $this->wishlistRepository->search($criteria, $context)->getEntities();

    foreach ($wishlistItems as $wishlistItem) {
        $this->wishlistRepository->delete([['id' => $wishlistItem->id]], $context);
    }
    }

    


}
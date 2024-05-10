<?php declare(strict_types=1);

namespace Wishlistv2\Storefront\Controller;

use DateTime;
use Shopware\Core\Framework\Context;
use Shopware\Core\Framework\Uuid\Uuid;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Shopware\Core\Checkout\Cart\LineItem\LineItem;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Shopware\Core\Checkout\Cart\SalesChannel\CartService;
use Shopware\Core\System\SalesChannel\SalesChannelContext;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Criteria;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Shopware\Core\Framework\DataAbstractionLayer\EntityRepository;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Filter\EqualsFilter;


#[Route(defaults: ['_routeScope' => ['storefront']])]
class Wishlistv2Controller extends AbstractController
{
    private $wishlistRepository;
    private $productRepository;
    private $customerRepository;
    public  $context;
    private $cartService;

    public function __construct(EntityRepository  $wishlistRepository, EntityRepository $productRepository, EntityRepository $customerRepository, CartService $cartService)
    {
       $this->wishlistRepository = $wishlistRepository; 
       $this->productRepository = $productRepository;
       $this->customerRepository = $customerRepository;
       $this->cartService = $cartService;
       
    }
    
    #[Route(
        path: '/wishlist/add/{productId}',
        name: 'my_plugin_wishlist_add',
        methods: ['GET']
    )]
    public function addToWishlist(Request $request, string $productId, SalesChannelContext $customer, Context $context): RedirectResponse
    {
        // Check if user is logged in
    if (!$customer->getCustomer()) {
        $this->addFlash('danger', 'Please login to add to wishlist.');
        return $this->redirectToRoute('frontend.account.login');
    }

    $customerId = $customer->getCustomer()->getId();

    // Check if the product is already in the wishlist
    if ($this->isProductInWishlist($customerId, $productId, $context)) {
        $this->addFlash('warning', 'Product is already in your wishlist.');
    } else {
        // Add product to User wishlist
        $this->addToUserWishlist($customerId, $productId, $context);
        $this->addFlash('success', 'Product added to your wishlist.');
    }

    // Redirect back to the product page
    return $this->redirectToRoute('frontend.detail.page', ['productId' => $productId]);
    }


    //Function checks if there us a product in wishlist 
    private function isProductInWishlist(string $userId, string $productId, Context $context): bool
    {
    $criteria = new Criteria();
    $criteria->addFilter(new EqualsFilter('userId', $userId));
    $criteria->addFilter(new EqualsFilter('productId', $productId));
   
    $wishlistItems = $this->wishlistRepository->search($criteria, $context)->getTotal();
    
   
    //Array wishlist total will be greater than 0 if item is present
    return $wishlistItems > 0;
    }
    

    private function addToUserWishlist(string $userId, string $productId, Context $context): void
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

    #[Route(
        path: '/account/wishlist',
        name: 'show_wishlist',
        methods: ['GET']
    )]
    public function showWishlist(SalesChannelContext $context): Response
    {   
    
        $customer = $context->getCustomer();
    // Get the current logged-in customer ID
        

        if($customer===null){
            return $this->redirectToRoute('frontend.account.login');
        }

        $customerId = $customer->getId(); 
        $criteria = new Criteria();
        $criteria->addFilter(new EqualsFilter('userId', $customerId));

        $wishlistItems = $this->wishlistRepository->search($criteria, $context->getContext());

        /// Initialize an array to store productIds
        $products = [];

        $userId = null;

    // Iterate over Wishlist items
    foreach ($wishlistItems->getEntities() as $wishlistItem) {
        // Access productId from each Wishlist entity directly
        $productId = $wishlistItem->productId;
        $userId = $wishlistItem->userId;

        

        $productcriteria = new Criteria([$productId]);
        $productcriteria->addAssociation('cover');

        // Retrieve product entity based on productId
        $product = $this->productRepository->search($productcriteria, $context->getContext())->first();

        // If product exists, add it to the array
        if ($product) {
            $products[] = $product;
        }
    }
       // Render the template with products array available
    return $this->render('@Wishlistv2/storefront/page/account/_page.html.twig', [
        'products' => $products,
        'user' =>$userId
    ]);
    }



    #[Route(
        path: '/wishlist/delete/{productId}',
        name: 'wishlist_delete',
        methods: ['DELETE']
    )]
    public function deleteFromWishlist(Request $request, string $productId, SalesChannelContext $customer, Context $context): RedirectResponse 
    {
        // Check if user is logged in
        if (!$customer->getCustomer()) {
            return $this->addFlash('danger', 'User Not logged in.');
        }
    
        $customerId = $customer->getCustomer()->getId();
    
        
        if ($this->isProductInWishlist($customerId, $productId, $context)) {
            
            $this->removeFromUserWishlist($customerId, $productId, $context);
            
            $this->addFlash('success', 'Product removed from your wishlist.');
        } else {
            $this->addFlash('warning', 'Product is not found in wishlist.');
        }
    
        
        

        return $this->redirectToRoute('show_wishlist');
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

    #[Route(
        path: '/share',
        name: 'share',
        methods: ['GET']
    )]
    public function getUserBY(Request $request, Context $context)
    {
        $products = [];
        $shareId = $request->query->get('shareId'); 

        if ($shareId) {
        //Getting Customer name by searching ID
        $customerCriteria = new Criteria();
        $customerCriteria->addFilter(new EqualsFilter('id', $shareId));
        $customers = $this->customerRepository->search($customerCriteria, $context);
        
        foreach($customers->getEntities() as $customer){
            $customerName = $customer->firstName;
      }
        //fINDING PRODUCTS BY USER id
        $criteria = new Criteria();
        $criteria->addFilter(new EqualsFilter('userId', $shareId));
        $wishlistItems = $this->wishlistRepository->search($criteria, $context);

        foreach ($wishlistItems->getEntities() as $wishlistItem) {
            // Access productId from each Wishlist entity directly
            $productId = $wishlistItem->productId;
            $productcriteria = new Criteria([$productId]);
            $productcriteria->addAssociation('cover');
            // Retrieve product entity based on productId
            $product = $this->productRepository->search($productcriteria, $context)->first();
            // If product exists, add it to the array
            if ($product) {
                $products[] = $product;
            }   
        }
        return $this->render('@Wishlistv2/storefront/page/checkout/cart/index.html.twig', [
            'products' => $products,
            'customerName' => $customerName,
            
        ]);
        
        }
    }



    #[Route(
        path: '/wishlist/cart',
        name: 'frontend.wishlist.to.cart',
        methods: ['POST']
    )]
    public function addBasket(Request $request, SalesChannelContext $context): Response
    {
        $productId = $request->query->get('productId');
        

        $cart = $this->cartService->getCart($context->getToken(), $context);

        $lineItem = new LineItem(Uuid::randomHex(), LineItem::PRODUCT_LINE_ITEM_TYPE, $productId);
        $lineItem->setReferencedId($productId);
        $lineItem->setStackable(true);
        $lineItem->setRemovable(true);

        $cart = $this->cartService->add($cart, $lineItem, $context);

        // // remove from wishlist
        // $this->remove($productId, $context->getContext());

        return $this->redirectToRoute('show_wishlist');
    }


    //Share Controller
    #[Route(
        name: 'wishlist.to.cart',
        methods: ['POST']
    )]
    public function addShareBasket(Request $request, SalesChannelContext $context): Response
    {
        $productId = $request->query->get('productId');
        

        $cart = $this->cartService->getCart($context->getToken(), $context);

        $lineItem = new LineItem($productId, LineItem::PRODUCT_LINE_ITEM_TYPE, $productId);
        $lineItem->setReferencedId($productId);
        $lineItem->setStackable(true);
        $lineItem->setRemovable(true);


        $cart = $this->cartService->add($cart, $lineItem, $context);

        return $this->redirectToRoute('share');
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

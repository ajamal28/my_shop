<?php declare(strict_types=1);

namespace Wishlistv2\Storefront\Controller;

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
use Wishlistv2\Service\WishlistService; 

#[Route(defaults: ['_routeScope' => ['storefront']])]
class Wishlistv2Controller extends AbstractController
{
    private $wishlistRepository;
    private $productRepository;
    private $customerRepository;
    public  $context;
    private $cartService;
    public $wishlistService;

    public function __construct(EntityRepository  $wishlistRepository, EntityRepository $productRepository, EntityRepository $customerRepository, CartService $cartService, WishlistService $wishlistService)
    {
       $this->wishlistRepository = $wishlistRepository; 
       $this->productRepository = $productRepository;
       $this->customerRepository = $customerRepository;
       $this->cartService = $cartService;
       $this->wishlistService = $wishlistService;
       
    }

    //Adding product to wishlist and checking if it's existent
    #[Route(path: '/wishlist/add/{productId}', name: 'my_plugin_wishlist_add', methods: ['GET'])]
    public function addToWishlist(string $productId, SalesChannelContext $customer, Context $context): RedirectResponse
    {
      // Checks if user is logged in
        if (!$customer->getCustomer()) {
        $this->addFlash('danger', 'Please login to add to wishlist.');
        return $this->redirectToRoute('frontend.account.login');
        }
        $customerId = $customer->getCustomer()->getId();

        if ($this->wishlistService->isProductInWishlist($customerId, $productId, $context)) {
        $this->addFlash('warning', 'Product is already in your wishlist.');
        } else {
        $this->wishlistService->addToUserWishlist($customerId, $productId, $context);
        $this->addFlash('success', 'Product added to your wishlist.');
        }

         // Redirect back to the product page
         return $this->redirectToRoute('frontend.detail.page', ['productId' => $productId]);
    }

    //ShowWishlist
    #[Route(path: '/account/wishlist', name: 'show_wishlist',methods: ['GET'])]
    public function showWishlist(SalesChannelContext $context): Response
    {  
        // Get the current logged-in customer ID 
        $customer = $context->getCustomer();
        
        if($customer===null){
            return $this->redirectToRoute('frontend.account.login');
        }

        $customerId = $customer->getId(); 
        $criteria = new Criteria();
        $criteria->addFilter(new EqualsFilter('userId', $customerId));

        $wishlistItems = $this->wishlistRepository->search($criteria, $context->getContext());

        /// Initialise products and user id to send null products to wishlist if no products in wishlist
        $products = [];
        $userId = null;

        // Iterate over Wishlist items
        foreach ($wishlistItems->getEntities() as $wishlistItem) {
        // Access productId from each Wishlist entity directly
        $productId = $wishlistItem->productId;
        $userId = $wishlistItem->userId;

        $productCriteria = new Criteria([$productId]);
        $productCriteria->addAssociation('cover');

        // Retrieve product entity based on productId
        $product = $this->productRepository->search($productCriteria, $context->getContext())->first();

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


    //Deleting from wishlist
    #[Route(path: '/wishlist/delete/{productId}', name: 'wishlist_delete', methods: ['DELETE'])]
    public function deleteFromWishlist(string $productId, SalesChannelContext $customer, Context $context): RedirectResponse 
    {
        // Check if user is logged in
        if (!$customer->getCustomer()) {
            return $this->addFlash('danger', 'User Not logged in.');
        }
        $customerId = $customer->getCustomer()->getId();
        
        if ($this->wishlistService->isProductInWishlist($customerId, $productId, $context)) 
            {
            $this->wishlistService->removeFromUserWishlist($customerId, $productId, $context);
            $this->addFlash('success', 'Product removed from your wishlist.');
            } else {
            $this->addFlash('warning', 'Product is not found in wishlist.');
            }
    
        return $this->redirectToRoute('show_wishlist');
    }
    

    //Share wishlist
    #[Route(path: '/share', name: 'share',methods: ['GET'])]
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


    //Add to Cart
    #[Route(path: '/wishlist/cart', name: 'frontend.wishlist.to.cart', methods: ['POST'], defaults: ['XmlHttpRequest' => true])]
     public function addBasket(Request $request, SalesChannelContext $context): Response
    {
        $productId = $request->query->get('productId');
        $cart = $this->cartService->getCart($context->getToken(), $context);

        $lineItem = new LineItem(Uuid::randomHex(), LineItem::PRODUCT_LINE_ITEM_TYPE, $productId);
        $lineItem->setReferencedId($productId);
        $lineItem->setStackable(true);
        $lineItem->setRemovable(true);

        $cart = $this->cartService->add($cart, $lineItem, $context);

        return $this->redirectToRoute('show_wishlist');
    }


    //Share Controller
    #[Route(name: 'wishlist.to.cart',methods: ['POST'])]
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




   


    




    
}

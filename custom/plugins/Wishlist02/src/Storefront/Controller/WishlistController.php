<?php declare(strict_types=1);

namespace Wishlist\Storefront\Controller;

use Shopware\Core\System\SalesChannel\SalesChannelContext;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\User\UserInterface;

#[Route(defaults: ['_routeScope' => ['storefront']])]
class WishlistController extends AbstractController
{
    
    #[Route(
        path: '/wishlist/add/{productId}',
        name: 'my_plugin_wishlist_add',
        methods: ['GET']
    )]
    public function addToWishlist(Request $request, string $productId, SalesChannelContext $customer): RedirectResponse
    {
        // Check if user is logged in
       // User is not logged in
        if(!$customer->getCustomer()){

        return $this->redirectToRoute('frontend.account.login');
        }

        // Add product to wishlist
        $this->addToUserWishlist($customer->getCustomer()->getId(), $productId);

        // Redirect back to the product page
        return $this->redirectToRoute('frontend.detail.page', ['productId' => $productId]);
    }
    

    private function addToUserWishlist(string $userId, string $productId): void
    {
        //TODO
    }
}

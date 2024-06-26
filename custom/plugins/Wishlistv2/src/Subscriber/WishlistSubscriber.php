<?php declare(strict_types=1);

namespace Wishlistv2\Subscriber;


use Shopware\Core\Checkout\Cart\LineItem\LineItem;
use Shopware\Core\Checkout\Cart\Event\CheckoutOrderPlacedEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Wishlistv2\Service\WishlistService;

class WishlistSubscriber implements EventSubscriberInterface

{
    private $wishlistService;

    public function __construct(WishlistService $wishlistService)
    {
        $this->wishlistService = $wishlistService;
    }

    public static function getSubscribedEvents()
    {
        return [
            CheckoutOrderPlacedEvent::class => 'onOrderPlaced'
        ];
    }

    public function onOrderPlaced(CheckoutOrderPlacedEvent $event)
    {
        $order = $event->getOrder();
        $lineItems = $order->getLineItems();

        if (!$lineItems) {
            return;
        }

        $context = $event->getContext();

        foreach ($lineItems as $lineItem) {
            if ($lineItem->getType() === LineItem::PRODUCT_LINE_ITEM_TYPE) {
                $productId = $lineItem->getReferencedId();
                $this->wishlistService->remove($productId, $context);
            }
        }
    }

    

    
}


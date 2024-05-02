<?php declare(strict_types=1);

namespace Wishlistv2\Core\Content\Wishlistv2;


use Wishlistv2\Core\Content\Wishlistv2\Wishlistv2Entity;
use Shopware\Core\Framework\DataAbstractionLayer\EntityCollection;


class Wishlistv2Collection extends EntityCollection
{
    protected function getExpectedClass(): string
    {
        return Wishlistv2Entity::class;
    }
}

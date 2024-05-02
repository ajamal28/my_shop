<?php declare(strict_types=1);

namespace Wishlist\Core\Content\Wishlist;


use Shopware\Core\Framework\DataAbstractionLayer\EntityDefinition;
use Shopware\Core\Framework\DataAbstractionLayer\Field\CreatedAtField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\IdField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\ManyToOneAssociationField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\StringField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\UpdatedAtField;
use Shopware\Core\Framework\DataAbstractionLayer\FieldCollection;

class WishlistDefinition extends EntityDefinition
{
    public function getEntityName(): string
    {
        return 'wishlist';
    }

    public function getCollectionClass(): string
    {
        return WishlistCollection::class;
    }

    public function getEntityClass(): string
    {
        return WishlistEntity::class;
    }

    protected function defineFields(): FieldCollection
    {
        return new FieldCollection([
            new IdField('id', 'id'),
            new StringField('user_id', 'userId'),
            new StringField('product_id', 'productId'),
            new CreatedAtField(),
            new UpdatedAtField(),
            new ManyToOneAssociationField('user', 'user_id', 'id', WishlistDefinition::class),
        ]);
    }
}

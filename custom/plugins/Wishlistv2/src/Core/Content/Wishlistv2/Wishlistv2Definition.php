<?php declare(strict_types=1);

namespace Wishlistv2\Core\Content\Wishlistv2;

use Shopware\Core\Checkout\Customer\CustomerDefinition;
use Shopware\Core\Checkout\Customer\CustomerEntity;
use Shopware\Core\Framework\DataAbstractionLayer\Field\IdField;
use Shopware\Core\Framework\DataAbstractionLayer\FieldCollection;
use Shopware\Core\Framework\DataAbstractionLayer\EntityDefinition;
use Shopware\Core\Framework\DataAbstractionLayer\Field\StringField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\Flag\Required;
use Shopware\Core\Framework\DataAbstractionLayer\Field\CreatedAtField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\UpdatedAtField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\Flag\PrimaryKey;
use Shopware\Core\Framework\DataAbstractionLayer\Field\ManyToOneAssociationField;

class Wishlistv2Definition extends EntityDefinition
{
    public function getEntityName(): string
    {
        return 'wishlistv2';
    }

    public function getCollectionClass(): string
    {
        return Wishlistv2Collection::class;
    }

    public function getEntityClass(): string
    {
        return Wishlistv2Entity::class;
    }

    protected function defineFields(): FieldCollection
    {
        return new FieldCollection([
            (new IdField('id', 'id'))->addFlags(new PrimaryKey(), new Required()),
            new IdField('user_id', 'userId'),
            new IdField('product_id', 'productId'),
            new CreatedAtField(),
            new UpdatedAtField(),
            new ManyToOneAssociationField('user', 'user_id',CustomerDefinition::class),
        ]);
    }
}

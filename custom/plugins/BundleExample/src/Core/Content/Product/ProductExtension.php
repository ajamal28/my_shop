<?php declare(strict_types=1);

namespace BundleExample\Core\Content\Product;

use Shopware\Core\Content\Product\ProductDefinition;
use BundleExample\Core\Content\Bundle\BundleDefinition;
use Shopware\Core\Framework\DataAbstractionLayer\FieldCollection;
use Shopware\Core\Framework\DataAbstractionLayer\Field\ManyToOneAssociationField;
use BundleExample\Core\Content\Bundle\Aggregate\BundleProduct\BundleProductDefinition;

class ProductExtension 
{
    protected function getDefinitionClass(): string
    {
        return ProductDefinition::class;
    }
    public function extendFields(FieldCollection $collection): void
    {
        $collection->add(
            new ManyToOneAssociationField(
                'bundles',
                BundleDefinition::class,
                BundleProductDefinition::class,
                'product_id' 
            )
            );
    }

}
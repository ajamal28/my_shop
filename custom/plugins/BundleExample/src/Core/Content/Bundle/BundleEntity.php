<?php declare(strict_types=1);

namespace BundleExample\Core\Content\Bundle;

use Shopware\Core\Content\Product\ProductCollection;
use Shopware\Core\Framework\DataAbstractionLayer\Entity;
use Shopware\Core\Framework\DataAbstractionLayer\EntityIdTrait;

class BundleEntity extends Entity
{
    use EntityIdTrait;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $discountType;

    /**
     * @var float
     */
    protected $discount;

    protected $products;
    
    protected function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name =$name;
    }

    /**
     * Get the value of discountType
     */
    public function getDiscountType(): string
    {
        return $this->discountType;
    }

    /**
     * Set the value of discountType
     */
    public function setDiscountType(string $discountType): self
    {
        $this->discountType = $discountType;

        return $this;
    }

    /**
     * Get the value of discount
     */
    public function getDiscount(): float
    {
        return $this->discount;
    }

    /**
     * Set the value of discount
     */
    public function setDiscount(float $discount): self
    {
        $this->discount = $discount;

        return $this;
    }

    /**
     * Get the value of products
     */
    public function getProducts(): ?ProductCollection
    {
        return $this->products;
    }

    /**
     * Set the value of products
     */
    public function setProducts(ProductCollection $products): void
    {
        $this->products = $products;

       
    }
}
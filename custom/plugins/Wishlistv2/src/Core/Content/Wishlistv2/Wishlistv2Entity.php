<?php declare(strict_types=1);

namespace Wishlistv2\Core\Content\Wishlistv2;

use Shopware\Core\Framework\DataAbstractionLayer\Entity;
use Shopware\Core\Framework\DataAbstractionLayer\EntityIdTrait;

class Wishlistv2Entity extends Entity
{
    use EntityIdTrait;

    /**
     * @var string
     */
    protected $userId;

    /**
     * @var string
     */
    protected $productId;

    /**
     * @return string
     */
    public function getUserId(): string
    {
        return $this->userId;
    }

    /**
     * @param string $userId
     */
    public function setUserId(string $userId): void
    {
        $this->userId = $userId;
    }

    /**
     * @return string
     */
    public function getProductId(): string
    {
        return $this->productId;
    }

    /**
     * @param string $productId
     */
    public function setProductId(string $productId): void
    {
        $this->productId = $productId;
    }
}
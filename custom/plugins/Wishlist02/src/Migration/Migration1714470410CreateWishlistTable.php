<?php declare(strict_types=1);

namespace Wishlist\Migration;

use Doctrine\DBAL\Connection;
use Shopware\Core\Framework\Migration\MigrationStep;

class Migration1714470410CreateWishlistTable extends MigrationStep
{
    public function getCreationTimestamp(): int
    {
        return 1714470410;
    }

    public function update(Connection $connection): void
    {

        $sql = <<<SQL
        CREATE TABLE IF NOT EXISTS `wishlist` (
            `id` BINARY(16) NOT NULL PRIMARY KEY,
            `user_id` BINARY(16) NOT NULL,
            `product_id` BINARY(16) NOT NULL,
            `created_at` DATETIME(3) NOT NULL,
            `updated_at` DATETIME(3),
            CONSTRAINT `fk_wishlist_user_id` FOREIGN KEY (`user_id`) REFERENCES `customer` (`id`) ON DELETE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
        SQL;
        
        $connection->executeStatement($sql);

     
    }

    public function updateDestructive(Connection $connection): void
    {
    }
}

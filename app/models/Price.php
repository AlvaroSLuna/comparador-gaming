<?php

require_once __DIR__ . '/../../config/database.php';

class Price
{
    public static function getByProduct($productId)
    {
        global $pdo;

        $stmt = $pdo->prepare("
            SELECT s.name AS store, s.website, p.price, p.product_url
            FROM prices p
            JOIN stores s ON p.store_id = s.id
            WHERE p.product_id = :product_id
            ORDER BY p.price ASC
        ");

        $stmt->execute(['product_id' => $productId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

<?php

require_once __DIR__ . '/../../config/database.php';

class Wishlist
{
    public static function add($userId, $productId)
    {
        global $pdo;

        $stmt = $pdo->prepare("
            INSERT IGNORE INTO wishlists (user_id, product_id)
            VALUES (:user_id, :product_id)
        ");

        return $stmt->execute([
            'user_id' => $userId,
            'product_id' => $productId
        ]);
    }

    public static function remove($userId, $productId)
    {
        global $pdo;

        $stmt = $pdo->prepare("
            DELETE FROM wishlists
            WHERE user_id = :user_id AND product_id = :product_id
        ");

        return $stmt->execute([
            'user_id' => $userId,
            'product_id' => $productId
        ]);
    }

    public static function getByUser($userId)
    {
        global $pdo;

        $stmt = $pdo->prepare("
            SELECT p.*
            FROM products p
            JOIN wishlists w ON p.id = w.product_id
            WHERE w.user_id = :user_id
        ");

        $stmt->execute(['user_id' => $userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

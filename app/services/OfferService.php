<?php

require_once __DIR__ . '/../../config/database.php';

class OfferService
{
    public static function getActiveOffers($limit = 10)
    {
        global $pdo;

        return $pdo->query("
            SELECT p.id, p.name, MIN(pr.price) AS best_price
            FROM products p
            JOIN prices pr ON p.id = pr.product_id
            JOIN price_history ph ON p.id = ph.product_id
            WHERE pr.price < ph.price
            GROUP BY p.id
            ORDER BY best_price ASC
            LIMIT $limit
        ")->fetchAll(PDO::FETCH_ASSOC);
    }
}

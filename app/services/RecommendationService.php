<?php

require_once __DIR__ . '/../../config/database.php';

class RecommendationService
{
    public static function bySearches($userId)
    {
        global $pdo;

        return $pdo->prepare("
            SELECT DISTINCT p.*
            FROM products p
            JOIN searches s ON p.name LIKE CONCAT('%', s.query, '%')
            WHERE s.user_id = :user
            LIMIT 5
        ");
    }
}

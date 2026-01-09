<?php

require_once __DIR__ . '/../../config/database.php';

class Search
{
    public static function store($query, $userId = null)
    {
        global $pdo;

        $stmt = $pdo->prepare("
            INSERT INTO searches (user_id, query)
            VALUES (:user_id, :query)
        ");

        $stmt->execute([
            'user_id' => $userId,
            'query' => $query
        ]);
    }

    public static function lastByUser($userId, $limit = 5)
    {
        global $pdo;

        $stmt = $pdo->prepare("
            SELECT query
            FROM searches
            WHERE user_id = :user_id
            ORDER BY created_at DESC
            LIMIT $limit
        ");

        $stmt->execute(['user_id' => $userId]);
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }
}

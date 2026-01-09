<?php

require_once __DIR__ . '/../../config/database.php';

class Product
{
    public static function search($query)
{
    global $pdo;

    $stmt = $pdo->prepare("
        SELECT *
        FROM products
        WHERE name LIKE :query
    ");

    $stmt->execute([
        'query' => '%' . $query . '%'
    ]);

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

    public static function all()
    {
        global $pdo;
        return $pdo->query("SELECT * FROM products")->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function find($id)
    {
        global $pdo;
        $stmt = $pdo->prepare("SELECT * FROM products WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}

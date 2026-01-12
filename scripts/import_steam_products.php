<?php

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../app/services/SteamService.php';

$games = SteamService::getGames();

foreach ($games as $game) {

    // Insertar producto si no existe
    $stmt = $pdo->prepare("
        INSERT IGNORE INTO products (name, category)
        VALUES (:name, 'Juego')
    ");
    $stmt->execute(['name' => $game['name']]);

    // Obtener ID del producto
    $productId = $pdo->lastInsertId();
    if (!$productId) {
        $productId = $pdo->query("
            SELECT id FROM products WHERE name = " . $pdo->quote($game['name'])
        )->fetchColumn();
    }

    // Insertar precio (Steam como tienda)
    $stmt = $pdo->prepare("
        INSERT INTO prices (product_id, store_id, price, product_url)
        VALUES (:product, 1, :price, :url)
        ON DUPLICATE KEY UPDATE price = :price
    ");

    $stmt->execute([
        'product' => $productId,
        'price' => $game['price'],
        'url' => $game['url']
    ]);
}

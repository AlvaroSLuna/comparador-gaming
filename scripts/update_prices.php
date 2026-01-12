<?php

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/scrapers/PcComponentesScraper.php';

$stmt = $pdo->query("
    SELECT p.id, p.product_url, s.name AS store
    FROM prices p
    JOIN stores s ON p.store_id = s.id
");

$prices = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($prices as $item) {

    echo "Actualizando {$item['store']}...\n";

    switch ($item['store']) {
        case 'PcComponentes':
            $newPrice = PcComponentesScraper::getPrice($item['product_url']);
            break;
        default:
            $newPrice = null;
    }

    if ($newPrice) {
        // Guardar histórico antes de actualizar
        $history = $pdo->prepare("
        INSERT INTO price_history (product_id, store_id, price)
        SELECT product_id, store_id, price
        FROM prices
        WHERE id = :id
    ");
        $history->execute(['id' => $item['id']]);

        // Actualizar precio
        $update = $pdo->prepare("
        UPDATE prices
        SET price = :price
        WHERE id = :id
    ");
        $update->execute([
            'price' => $newPrice,
            'id' => $item['id']
        ]);

        echo "✔ Nuevo precio: $newPrice €\n";

        $alerts = $pdo->prepare("
    SELECT pa.id, u.email
    FROM price_alerts pa
    JOIN users u ON pa.user_id = u.id
    WHERE pa.product_id = :product
      AND pa.active = 1
      AND :price <= pa.target_price
");

        $alerts->execute([
            'product' => $item['product_id'],
            'price' => $newPrice
        ]);
    }
}

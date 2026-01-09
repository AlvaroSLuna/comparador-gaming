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
    } else {
        echo "✖ No se pudo obtener precio\n";
    }
}

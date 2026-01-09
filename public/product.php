<?php
require_once '../config/app.php';
require_once '../app/helpers/session.php';
require_once '../app/models/Product.php';
require_once '../app/models/Price.php';

$productId = $_GET['id'] ?? null;
$product = Product::find($productId);

if (!$product) {
    die('Producto no encontrado');
}

$prices = Price::getByProduct($productId);
?>

<h1><?= $product['name'] ?></h1>

<h3>Comparar precios</h3>

<?php if (!$prices): ?>
    <p>No hay precios disponibles.</p>
<?php else: ?>
    <table border="1" cellpadding="5">
        <tr>
            <th>Tienda</th>
            <th>Precio</th>
            <th></th>
        </tr>

        <?php foreach ($prices as $price): ?>
            <tr>
                <td><?= $price['store'] ?></td>
                <td><?= number_format($price['price'], 2) ?> €</td>
                <td>
                    <a href="<?= $price['product_url'] ?>" target="_blank">
                        Ir a la tienda
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
<?php endif; ?>

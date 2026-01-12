<?php
require_once '../config/app.php';
require_once '../app/helpers/session.php';
require_once '../app/models/Product.php';
require_once '../app/models/Search.php';

$query = $_GET['q'] ?? null;
$results = [];

if ($query) {
    // Guardamos búsqueda
    Search::store($query, $_SESSION['user_id'] ?? null);

    // Buscamos productos
    $results = Product::search($query);
}
?>

<h1>Buscar productos</h1>

<form method="GET">
    <input type="text" name="q" placeholder="Buscar gaming..." value="<?= htmlspecialchars($query) ?>">
    <button>Buscar</button>
</form>

<hr>

<?php if ($query): ?>
    <h3>Resultados para "<?= htmlspecialchars($query) ?>"</h3>

    <?php if (!$results): ?>
        <p>No se encontraron productos.</p>
    <?php endif; ?>

    <?php foreach ($results as $product): ?>
        <div>
            <a href="product.php?id=<?= $product['id'] ?>">
                <?= htmlspecialchars($product['name']) ?>
            </a>
            <?php if (isLoggedIn()): ?>
                <form method="POST" action="add_wishlist.php">
                    <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                    <button type="submit">❤️</button>
                </form>

            <?php endif; ?>
        </div>
    <?php endforeach; ?>
<?php endif; ?>
<?php
require_once '../app/helpers/session.php';
require_once '../app/models/Wishlist.php';

requireLogin();

$items = Wishlist::getByUser($_SESSION['user_id']);
?>

<h1>Mi Wishlist</h1>

<?php if (!$items): ?>
    <p>No tienes productos aún.</p>
<?php endif; ?>

<?php foreach ($items as $item): ?>
    <div>
        <?= $item['name'] ?>
        <form method="POST" action="remove_wishlist.php" style="display:inline">
            <input type="hidden" name="product_id" value="<?= $item['id'] ?>">
            <button>❌</button>
        </form>
    </div>
    <form method="POST" action="add_alert.php">
        <input type="hidden" name="product_id" value="<?= $item['id'] ?>">
        <input type="number" step="0.01" name="target_price" placeholder="Precio deseado">
        <button>🔔 Alertar</button>
    </form>

<?php endforeach; ?>
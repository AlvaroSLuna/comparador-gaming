<?php
require_once '../config/app.php';
require_once '../config/database.php';
require_once '../app/helpers/session.php';

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title><?= APP_NAME ?></title>
    <link rel="stylesheet" href="../assets/css/main.css">
</head>
<body>

<h1>Bienvenido a <?= APP_NAME ?></h1>

<?php if (isLoggedIn()): ?>
    <p>Hola usuario 👋</p>
    <a href="wishlist.php">Mi lista de deseados</a>
    <a href="logout.php">Cerrar sesión</a>
    <form method="GET" action="search.php">
    <input type="text" name="q" placeholder="Busca hardware, consolas...">
    <button>🔍</button>
</form>

<?php else: ?>
    <a href="login.php">Iniciar sesión</a>
    <a href="register.php">Registrarse</a>


    <?php
require_once '../app/models/Search.php';

if (isLoggedIn()) {
    $recentSearches = Search::lastByUser($_SESSION['user_id']);
}
?>

<?php if (isLoggedIn() && $recentSearches): ?>
    <h3>Basado en tus búsquedas</h3>
    <ul>
        <?php foreach ($recentSearches as $search): ?>
            <li>
                <a href="search.php?q=<?= urlencode($search) ?>">
                    <?= htmlspecialchars($search) ?>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>


<?php endif; ?>

</body>
</html>
    
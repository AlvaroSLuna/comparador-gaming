<?php
require_once '../config/app.php';
require_once '../config/database.php';
require_once '../app/helpers/session.php';
require_once '../app/services/OfferService.php';
require_once '../app/services/RecommendationService.php';
require_once '../app/helpers/layout.php';
headerLayout('Inicio');
$offers = OfferService::getActiveOffers();
$recommendations = [];

if (isLoggedIn()) {
    $stmt = RecommendationService::bySearches($_SESSION['user_id']);
    $stmt->execute(['user' => $_SESSION['user_id']]);
    $recommendations = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

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

        <?php if ($offers): ?>
            <h2>🔥 Ofertas destacadas</h2>

            <?php foreach ($offers as $offer): ?>
                <div>
                    <a href="product.php?id=<?= $offer['id'] ?>">
                        <?= htmlspecialchars($offer['name']) ?>
                    </a>
                    <strong><?= number_format($offer['best_price'], 2) ?> €</strong>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>

        <?php if (!empty($recommendations)): ?>
            <h2>🧠 Recomendado para ti</h2>
            <?php foreach ($recommendations as $rec): ?>
                <a href="product.php?id=<?= $rec['id'] ?>">
                    <?= htmlspecialchars($rec['name']) ?>
                </a><br>
            <?php endforeach; ?>
        <?php endif; ?>
        <?php foreach ($offers as $offer): ?>
            <div class="product-card">
                <div>
                    <strong><?= $offer['name'] ?></strong>
                </div>
                <div>
                    <span><?= number_format($offer['best_price'], 2) ?> €</span>
                    <a href="product.php?id=<?= $offer['id'] ?>">Comparar</a>
                </div>
            </div>
        <?php endforeach; ?>

    <?php endif; ?>
<?php footerLayout(); ?>

</body>

</html>
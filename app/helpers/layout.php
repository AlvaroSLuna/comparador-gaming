<?php function headerLayout($title) { ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title><?= $title ?></title>
    <link rel="stylesheet" href="../assets/css/main.css">
</head>
<body>

<header class="header">
    <a href="index.php" class="logo">ComparadorGaming</a>
    <form action="search.php" method="GET">
        <input type="text" name="q" placeholder="Busca hardware, juegos, consolas...">
    </form>
</header>

<main>
<?php } ?>

<?php function footerLayout() { ?>
</main>
</body>
</html>
<?php } ?>

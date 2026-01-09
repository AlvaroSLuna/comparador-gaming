<?php
require_once '../config/app.php';
require_once '../app/models/User.php';

$error = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $email    = trim($_POST['email']);
    $password = $_POST['password'];

    if ($username && $email && $password) {
        if (User::create($username, $email, $password)) {
            header('Location: login.php');
            exit;
        } else {
            $error = 'Error al registrar usuario';
        }
    } else {
        $error = 'Todos los campos son obligatorios';
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro</title>
</head>
<body>

<h2>Registro</h2>

<?php if ($error): ?>
    <p style="color:red"><?= $error ?></p>
<?php endif; ?>

<form method="POST">
    <input type="text" name="username" placeholder="Usuario">
    <input type="email" name="email" placeholder="Email">
    <input type="password" name="password" placeholder="Contraseña">
    <button type="submit">Registrarse</button>
</form>

</body>
</html>

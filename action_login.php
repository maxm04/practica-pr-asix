<?php
session_start();
require 'db_config.php'; // Conexión a la base de datos

// Verificar si se envió el formulario mediante POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener y sanitizar los datos de entrada
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $captcha_input = trim($_POST['captcha_input']);

    // Validación del CAPTCHA
    if (!isset($_SESSION['captcha']) || $captcha_input != $_SESSION['captcha']) {
        $_SESSION['message'] = "CAPTCHA incorrecto. Inténtalo de nuevo.";
        $_SESSION['message_type'] = "error";
        header("Location: login.php");
        exit;
    }

    // Preparar consulta segura para verificar usuario
    $stmt = $mysqli->prepare("SELECT password, created_at FROM usuarios WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->bind_result($hashed_password, $created_at);
    $stmt->fetch();

    if ($hashed_password && password_verify($password, $hashed_password)) {
        $_SESSION['message'] = "Inicio de sesión exitoso. Bienvenido, $username. Te registraste el: $created_at";
        $_SESSION['message_type'] = "success";
        header("Location: dashboard.php");
        exit;
    } else {
        $_SESSION['message'] = "Usuario o contraseña incorrectos. Inténtalo de nuevo.";
        $_SESSION['message_type'] = "error";
        header("Location: login.php");
        exit;
    }

    // Cerrar conexión y consulta
    $stmt->close();
    $mysqli->close();

    // Limpiar la variable de sesión del CAPTCHA después de la validación
    unset($_SESSION['captcha']);
} else {
    $_SESSION['message'] = "Acceso no permitido.";
    $_SESSION['message_type'] = "error";
    header("Location: login.php");
    exit;
}
?>

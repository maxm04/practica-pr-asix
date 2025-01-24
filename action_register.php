<?php
session_start();
require 'db_config.php'; // Incluir conexión a la base de datos

// Verificar si se envió el formulario mediante POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener y sanitizar los datos de entrada
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $captcha_input = trim($_POST['captcha_input']);
    $created_at = date('Y-m-d H:i:s'); // Fecha y hora actual

    // Validación del CAPTCHA
    if (!isset($_SESSION['captcha']) || $captcha_input != $_SESSION['captcha']) {
        $_SESSION['message'] = "CAPTCHA incorrecto. Inténtalo de nuevo.";
        $_SESSION['message_type'] = "error";
        header("Location: register.php");
        exit;
    }

    // Validar formato de correo electrónico
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['message'] = "Correo electrónico no válido. Inténtalo de nuevo.";
        $_SESSION['message_type'] = "error";
        header("Location: register.php");
        exit;
    }

    // Validar que el usuario no exista previamente
    $stmt = $mysqli->prepare("SELECT id FROM usuarios WHERE username = ?");
    if (!$stmt) {
        $_SESSION['message'] = "Error en la base de datos. Inténtalo más tarde.";
        $_SESSION['message_type'] = "error";
        header("Location: register.php");
        exit;
    }
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();
    
    if ($stmt->num_rows > 0) {
        $_SESSION['message'] = "El usuario ya existe. Intenta con otro nombre.";
        $_SESSION['message_type'] = "error";
        header("Location: register.php");
        exit;
    }
    $stmt->close();

    // Cifrar la contraseña de forma segura
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Insertar el nuevo usuario en la base de datos
    $stmt = $mysqli->prepare("INSERT INTO usuarios (username, email, password, created_at) VALUES (?, ?, ?, ?)");
    
    if (!$stmt) {
        $_SESSION['message'] = "Error al preparar la consulta de registro.";
        $_SESSION['message_type'] = "error";
        header("Location: register.php");
        exit;
    }

    $stmt->bind_param("ssss", $username, $email, $hashed_password, $created_at);

    if ($stmt->execute()) {
        $_SESSION['message'] = "Registro exitoso. ¡Inicia sesión ahora!";
        $_SESSION['message_type'] = "success";
        header("Location: login.php");
        exit;
    } else {
        $_SESSION['message'] = "Error en el registro. Inténtalo de nuevo.";
        $_SESSION['message_type'] = "error";
        header("Location: register.php");
        exit;
    }

    $stmt->close();

    // Limpiar la variable de sesión del CAPTCHA después de la validación
    unset($_SESSION['captcha']);
} else {
    $_SESSION['message'] = "Método no permitido.";
    $_SESSION['message_type'] = "error";
    header("Location: register.php");
    exit;
}

// Cerrar la conexión a la base de datos
$mysqli->close();
?>

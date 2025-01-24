<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
    <!-- Estilos CSS integrados -->
    <style>
        /* Estilo general */
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background: linear-gradient(to right, #6a11cb, #2575fc);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            color: #fff;
        }

        /* Contenedor principal */
        .login-container {
            background: #fff;
            padding: 2rem;
            border-radius: 15px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
            text-align: center;
            width: 90%;
            max-width: 400px;
        }

        /* Logo */
        .logo img {
            width: 100px;
            margin-bottom: 1rem;
        }

        /* Título */
        h1 {
            font-size: 1.8rem;
            color: #333;
        }

        /* Campos del formulario */
        form input {
            width: 100%;
            padding: 0.8rem;
            margin: 0.5rem 0;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        /* Botón */
        form button {
            width: 100%;
            padding: 0.8rem;
            margin-top: 1rem;
            background: #6a11cb;
            border: none;
            color: white;
            font-weight: bold;
            border-radius: 5px;
            cursor: pointer;
            transition: background 0.3s ease, transform 0.2s ease;
        }

        form button:hover {
            background: #2575fc;
            transform: translateY(-2px);
        }

        /* Enlace para registrarse */
        p a {
            color: #6a11cb;
            text-decoration: none;
            font-weight: bold;
        }

        p a:hover {
            text-decoration: underline;
        }
        p {
            color: #6a11cb;
        }
        input, button {
            display: block;
            width: 100%;
            margin: 10px 0;
            padding: 10px;
        }
        .message {
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 15px;
        }
        .success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <!-- Logo de la empresa -->
        <div class="logo">
            <img src="logo.png" alt="Logo de la Empresa" width="150">
        </div>
        
        <!-- Mostrar mensaje si existe -->
        <?php if (isset($_SESSION['message'])): ?>
            <div class="message <?php echo $_SESSION['message_type']; ?>">
                <?php 
                    echo $_SESSION['message']; 
                    unset($_SESSION['message']);  // Borrar el mensaje después de mostrarlo
                    unset($_SESSION['message_type']);
                ?>
            </div>
        <?php endif; ?>

        <!-- Título -->
        <h1>Iniciar Sesión</h1>

        <!-- Formulario de login con CAPTCHA -->
        <form action="action_login.php" method="POST">
            <input type="text" name="username" placeholder="Nombre de usuario" required>
            <input type="password" name="password" placeholder="Contraseña" required>

            <!-- CAPTCHA generado en imagen -->
            <div class="captcha">
                <img src="captcha.php" alt="CAPTCHA">
            </div>
            <input type="text" name="captcha_input" placeholder="Introduce el código CAPTCHA" required>

            <button type="submit">Acceder</button>
        </form>
        <!-- Enlace para registrarse -->
        <p>¿No tienes cuenta? <a href="register.php">Regístrate aquí</a></p>
    </div>
</body>
</html>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#2ecc71">
    <title>Login - Control Nutricional</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="manifest" href="manifest.json">
</head>
<body class="auth-page">
    <div class="auth-container">
        <div class="auth-card">
            <div class="logo">
                🥗
            </div>
            <h1>Control Nutricional</h1>
            <p class="subtitle">Inicia sesión en tu cuenta</p>

            <?php if (isset($error)): ?>
                <div class="alert alert-error">
                    <?= $error ?>
                </div>
            <?php endif; ?>

            <form method="POST" class="auth-form">
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" required 
                           placeholder="tu@email.com">
                </div>

                <div class="form-group">
                    <label for="password">Contraseña</label>
                    <input type="password" id="password" name="password" required 
                           placeholder="••••••••">
                </div>

                <button type="submit" class="btn btn-primary btn-block">
                    Iniciar Sesión
                </button>
            </form>

            <p class="auth-footer">
                ¿No tienes cuenta? 
                <a href="index.php?controller=auth&action=register">Regístrate aquí</a>
            </p>
        </div>
    </div>

    <script src="assets/js/app.js"></script>
</body>
</html>

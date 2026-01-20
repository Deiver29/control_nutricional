<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#2ecc71">
    <title>Registrar Peso - Control Nutricional</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="manifest" href="manifest.json">
</head>
<body class="onboarding-container">
    <div class="onboarding-card">
        <h2>⚖️ Registrar Nuevo Peso</h2>
        <p class="intro">
            Registra tu peso actual para hacer seguimiento de tu progreso
        </p>

        <?php if (isset($error)): ?>
            <div class="alert alert-error">
                <?= $error ?>
            </div>
        <?php endif; ?>

        <form method="POST" class="auth-form">
            
            <div class="form-group">
                <label for="weight_kg">Peso actual (kg)</label>
                <input type="number" id="weight_kg" name="weight_kg" required 
                       min="20" max="300" step="0.1" placeholder="70.5" autofocus>
            </div>

            <div class="form-group">
                <label for="notes">Notas (opcional)</label>
                <textarea id="notes" name="notes" rows="3" 
                          placeholder="Ej: Después de las vacaciones, pesaje matutino, etc."></textarea>
            </div>

            <button type="submit" class="btn btn-primary btn-block">
                💾 Guardar Peso
            </button>

            <a href="index.php?controller=weight&action=history" class="btn btn-secondary btn-block">
                ← Ver Historial
            </a>
        </form>
    </div>

    <script src="assets/js/app.js"></script>
</body>
</html>

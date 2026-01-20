<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#2ecc71">
    <title>Perfil Personal - Control Nutricional</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="manifest" href="manifest.json">
</head>
<body class="onboarding-container">
    <div class="onboarding-card">
        <h2>👤 Cuéntanos sobre ti</h2>
        <p class="intro">
            Necesitamos algunos datos para crear tu plan personalizado de nutrición
        </p>

        <?php if (isset($error)): ?>
            <div class="alert alert-error">
                <?= $error ?>
            </div>
        <?php endif; ?>

        <form method="POST" class="auth-form">
            
            <div class="form-group">
                <label>Género</label>
                <div class="radio-group">
                    <div class="radio-option">
                        <input type="radio" id="male" name="gender" value="M" required>
                        <label for="male">👨 Masculino</label>
                    </div>
                    <div class="radio-option">
                        <input type="radio" id="female" name="gender" value="F" required>
                        <label for="female">👩 Femenino</label>
                    </div>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="age">Edad</label>
                    <input type="number" id="age" name="age" required 
                           min="10" max="120" placeholder="25">
                </div>

                <div class="form-group">
                    <label for="height_cm">Altura (cm)</label>
                    <input type="number" id="height_cm" name="height_cm" required 
                           min="50" max="250" step="0.1" placeholder="170">
                </div>
            </div>

            <div class="form-group">
                <label for="weight_kg">Peso actual (kg)</label>
                <input type="number" id="weight_kg" name="weight_kg" required 
                       min="20" max="300" step="0.1" placeholder="70">
            </div>

            <div class="form-group">
                <label>¿Cuál es tu objetivo?</label>
                <div class="radio-group">
                    <div class="radio-option">
                        <input type="radio" id="lose" name="goal" value="lose" required>
                        <label for="lose">📉 Bajar de peso</label>
                    </div>
                    <div class="radio-option">
                        <input type="radio" id="maintain" name="goal" value="maintain" required>
                        <label for="maintain">⚖️ Mantener</label>
                    </div>
                    <div class="radio-option">
                        <input type="radio" id="gain" name="goal" value="gain" required>
                        <label for="gain">📈 Subir de peso</label>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label>Nivel de actividad física</label>
                <div class="radio-group">
                    <div class="radio-option">
                        <input type="radio" id="low" name="activity" value="low" required>
                        <label for="low">🛋️ Sedentario</label>
                    </div>
                    <div class="radio-option">
                        <input type="radio" id="medium" name="activity" value="medium" required>
                        <label for="medium">🚶 Moderado</label>
                    </div>
                    <div class="radio-option">
                        <input type="radio" id="high" name="activity" value="high" required>
                        <label for="high">🏃 Activo</label>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-primary btn-block">
                Continuar →
            </button>
        </form>
    </div>

    <script src="assets/js/app.js"></script>
</body>
</html>

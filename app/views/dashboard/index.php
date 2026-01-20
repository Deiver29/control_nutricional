<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#2ecc71">
    <title>Dashboard - Control Nutricional</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="manifest" href="manifest.json">
</head>
<body class="dashboard">
    
    <!-- Navbar -->
    <nav class="navbar">
        <div class="navbar-brand">
            🥗 Control Nutricional
        </div>
        <div class="navbar-user">
            <span>Hola, <strong><?= htmlspecialchars($data['user']['name']) ?></strong></span>
            <a href="index.php?controller=auth&action=logout" class="btn btn-secondary">
                Cerrar Sesión
            </a>
        </div>
    </nav>

    <!-- Contenido Principal -->
    <div class="container">
        
        <!-- Estadísticas -->
        <div class="stats-grid">
            
            <!-- IMC -->
            <div class="stat-card">
                <h3>📊 Índice de Masa Corporal</h3>
                <div class="stat-value" style="color: <?= $data['imcStatus']['color'] ?>">
                    <?= $data['imc'] ?>
                </div>
                <div class="stat-label">
                    <?= $data['imcStatus']['status'] ?>
                </div>
                <div class="imc-indicator">
                    <div class="imc-bar" style="width: <?= min(($data['imc'] / 35) * 100, 100) ?>%; background: <?= $data['imcStatus']['color'] ?>"></div>
                </div>
            </div>

            <!-- Peso Actual -->
            <div class="stat-card">
                <h3>⚖️ Peso Actual</h3>
                <div class="stat-value">
                    <?= $data['profile']['weight_kg'] ?> <small style="font-size: 18px;">kg</small>
                </div>
                <div class="stat-label">
                    Altura: <?= $data['profile']['height_cm'] ?> cm
                </div>
            </div>

            <!-- Calorías Diarias -->
            <div class="stat-card">
                <h3>🔥 Calorías Diarias Recomendadas</h3>
                <div class="stat-value" style="color: var(--primary)">
                    <?= $data['tdee'] ?>
                </div>
                <div class="stat-label">
                    kcal/día
                </div>
            </div>

            <!-- Objetivo -->
            <div class="stat-card">
                <h3>🎯 Tu Objetivo</h3>
                <div class="stat-value" style="font-size: 24px;">
                    <?php 
                    $goals = [
                        'lose' => '📉 Bajar de peso',
                        'maintain' => '⚖️ Mantener',
                        'gain' => '📈 Subir de peso'
                    ];
                    echo $goals[$data['profile']['goal']];
                    ?>
                </div>
                <div class="stat-label">
                    Actividad: 
                    <?php 
                    $activities = [
                        'low' => 'Sedentario',
                        'medium' => 'Moderado',
                        'high' => 'Activo'
                    ];
                    echo $activities[$data['profile']['activity']];
                    ?>
                </div>
            </div>

        </div>

        <!-- Recomendaciones -->
        <div class="diet-section">
            <h2>💡 Recomendaciones Personalizadas</h2>
            
            <?php if ($data['imc'] < 18.5): ?>
                <div class="alert alert-info">
                    <strong>Bajo peso:</strong> Es importante que aumentes tu ingesta calórica de forma saludable. 
                    Incluye más proteínas, carbohidratos complejos y grasas saludables en tu dieta.
                </div>
            <?php elseif ($data['imc'] < 25): ?>
                <div class="alert alert-success">
                    <strong>¡Excelente!</strong> Tu peso está en un rango saludable. 
                    Mantén una dieta balanceada y continúa con tu nivel de actividad física.
                </div>
            <?php elseif ($data['imc'] < 30): ?>
                <div class="alert alert-info">
                    <strong>Sobrepeso:</strong> Considera reducir tu ingesta calórica en 300-500 kcal/día. 
                    Enfócate en alimentos ricos en fibra, proteínas magras y reduce los carbohidratos refinados.
                </div>
            <?php else: ?>
                <div class="alert alert-error">
                    <strong>Obesidad:</strong> Es importante que consultes con un profesional de la salud. 
                    Te recomendamos un plan de alimentación con déficit calórico moderado y actividad física regular.
                </div>
            <?php endif; ?>

            <div style="margin-top: 30px;">
                <a href="index.php?controller=diet&action=generate" class="btn btn-primary">
                    📋 Ver Plan de Alimentación
                </a>
                <a href="index.php?controller=weight&action=add" class="btn btn-primary">
                    ⚖️ Registrar Peso
                </a>
                <a href="index.php?controller=weight&action=history" class="btn btn-secondary">
                    📊 Ver Mi Progreso
                </a>
                <a href="index.php?controller=user&action=onboarding" class="btn btn-secondary">
                    ✏️ Actualizar Mi Perfil
                </a>
            </div>
        </div>

    </div>

    <script src="assets/js/app.js"></script>
</body>
</html>

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
            <div class="user-dropdown">
                <button class="user-menu-btn" id="userMenuBtn">
                    <span>👤 <?= htmlspecialchars($data['user']['name']) ?></span>
                    <span class="dropdown-arrow">▼</span>
                </button>
                <div class="dropdown-menu" id="userDropdown">
                    <div class="dropdown-header">
                        <strong><?= htmlspecialchars($data['user']['name']) ?></strong>
                        <small><?= htmlspecialchars($data['user']['email']) ?></small>
                    </div>
                    <div class="dropdown-divider"></div>
                    <a href="index.php?controller=diet&action=generate" class="dropdown-item">
                        📋 Ver Plan de Alimentación
                    </a>
                    <a href="index.php?controller=weight&action=add" class="dropdown-item">
                        ⚖️ Registrar Peso
                    </a>
                    <a href="index.php?controller=weight&action=history" class="dropdown-item">
                        📊 Ver Mi Progreso
                    </a>
                    <a href="index.php?controller=user&action=onboarding" class="dropdown-item">
                        ✏️ Actualizar Mi Perfil
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="index.php?controller=auth&action=logout" class="dropdown-item logout">
                        🚪 Cerrar Sesión
                    </a>
                </div>
            </div>
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

        <!-- Consejo del Día (Simulación IA) -->
        <?php if (isset($data['consejo']) && $data['consejo']): ?>
        <div class="diet-section">
            <h2>💡 Consejo Inteligente del Día</h2>
            
            <div class="card consejo-card" style="border-left: 4px solid var(--primary); background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);">
                <div style="display: flex; align-items: start; gap: 15px;">
                    <div style="font-size: 32px;">
                        <?php 
                        $iconos = [
                            'ejercicio' => '🏃‍♂️',
                            'nutricion' => '🥗',
                            'motivacion' => '💪'
                        ];
                        echo $iconos[$data['consejo']['tipo']] ?? '💡';
                        ?>
                    </div>
                    <div style="flex: 1;">
                        <div style="display: flex; gap: 10px; margin-bottom: 8px;">
                            <span style="background: var(--primary); color: white; padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: bold; text-transform: uppercase;">
                                <?= htmlspecialchars($data['consejo']['tipo']) ?>
                            </span>
                            <span style="background: rgba(0,0,0,0.1); color: #333; padding: 4px 12px; border-radius: 20px; font-size: 12px;">
                                <?php 
                                $objetivos = ['bajar' => 'Bajar', 'subir' => 'Subir', 'mantener' => 'Mantener'];
                                echo $objetivos[$data['consejo']['objetivo']] ?? '';
                                ?>
                            </span>
                        </div>
                        <p style="font-size: 16px; line-height: 1.6; margin: 0; color: #2c3e50;">
                            <?= htmlspecialchars($data['consejo']['mensaje']) ?>
                        </p>
                    </div>
                </div>
            </div>
            
            <div style="margin-top: 15px; text-align: right;">
                <button onclick="location.reload()" class="btn btn-secondary" style="font-size: 14px;">
                    🔄 Ver Otro Consejo
                </button>
            </div>
        </div>
        <?php endif; ?>

        <!-- Consejos Variados (Opcional) -->
        <?php if (isset($data['consejosVariados']) && !empty(array_filter($data['consejosVariados']))): ?>
        <div class="diet-section">
            <h2>📚 Más Consejos Para Ti</h2>
            
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 20px;">
                
                <?php if (isset($data['consejosVariados']['ejercicio']) && $data['consejosVariados']['ejercicio']): ?>
                <div class="card" style="border-top: 3px solid #3498db;">
                    <div style="font-size: 28px; margin-bottom: 10px;">🏃‍♂️</div>
                    <h4 style="color: #3498db; margin-bottom: 10px;">Ejercicio</h4>
                    <p style="font-size: 14px; line-height: 1.5; color: #555;">
                        <?= htmlspecialchars($data['consejosVariados']['ejercicio']['mensaje']) ?>
                    </p>
                </div>
                <?php endif; ?>
                
                <?php if (isset($data['consejosVariados']['nutricion']) && $data['consejosVariados']['nutricion']): ?>
                <div class="card" style="border-top: 3px solid #2ecc71;">
                    <div style="font-size: 28px; margin-bottom: 10px;">🥗</div>
                    <h4 style="color: #2ecc71; margin-bottom: 10px;">Nutrición</h4>
                    <p style="font-size: 14px; line-height: 1.5; color: #555;">
                        <?= htmlspecialchars($data['consejosVariados']['nutricion']['mensaje']) ?>
                    </p>
                </div>
                <?php endif; ?>
                
                <?php if (isset($data['consejosVariados']['motivacion']) && $data['consejosVariados']['motivacion']): ?>
                <div class="card" style="border-top: 3px solid #e74c3c;">
                    <div style="font-size: 28px; margin-bottom: 10px;">💪</div>
                    <h4 style="color: #e74c3c; margin-bottom: 10px;">Motivación</h4>
                    <p style="font-size: 14px; line-height: 1.5; color: #555;">
                        <?= htmlspecialchars($data['consejosVariados']['motivacion']['mensaje']) ?>
                    </p>
                </div>
                <?php endif; ?>
                
            </div>
        </div>
        <?php endif; ?>

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
        </div>

    </div>

    <script src="assets/js/app.js"></script>
    <script>
        // Manejo del menú desplegable
        const userMenuBtn = document.getElementById('userMenuBtn');
        const userDropdown = document.getElementById('userDropdown');

        userMenuBtn.addEventListener('click', function(e) {
            e.stopPropagation();
            userDropdown.classList.toggle('show');
        });

        // Cerrar al hacer clic fuera
        document.addEventListener('click', function() {
            userDropdown.classList.remove('show');
        });

        // Prevenir cierre al hacer clic dentro del dropdown
        userDropdown.addEventListener('click', function(e) {
            e.stopPropagation();
        });
    </script>
</body>
</html>

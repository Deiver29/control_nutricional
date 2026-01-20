<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#2ecc71">
    <title>Mi Plan de Alimentación - Control Nutricional</title>
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
            <a href="index.php?controller=dashboard&action=index" class="btn btn-secondary">
                ← Volver al Dashboard
            </a>
        </div>
    </nav>

    <!-- Contenido Principal -->
    <div class="container">
        
        <div class="diet-section">
            <h2>📋 Tu Plan de Alimentación Diario</h2>
            <p style="color: var(--gray); margin-bottom: 30px;">
                Plan personalizado para alcanzar tu objetivo de 
                <strong style="color: var(--primary);"><?= $data['totalCalories'] ?> kcal/día</strong>
            </p>

            <!-- Desayuno -->
            <div class="meal-card">
                <div class="meal-header">
                    <div class="meal-title">
                        🌅 Desayuno (25% - <?= $data['distribution']['breakfast'] ?> kcal)
                    </div>
                    <div class="meal-calories">
                        <?= $data['mealPlan']['breakfast']['totalCalories'] ?> kcal
                    </div>
                </div>
                
                <div class="alert alert-info" style="margin: 15px 0; font-size: 14px;">
                    💡 <strong>Ideas de desayuno:</strong> Avena con frutas • Huevos con tostadas • Yogurt con granola • Smoothie bowl
                </div>

                <?php if (!empty($data['mealPlan']['breakfast']['foods'])): ?>
                    <ul class="food-list">
                        <?php foreach ($data['mealPlan']['breakfast']['foods'] as $food): ?>
                            <li class="food-item">
                                <div style="display: flex; flex-direction: column; gap: 5px; width: 100%;">
                                    <div style="display: flex; justify-content: space-between; align-items: center;">
                                        <span class="food-name" style="font-weight: 600;">
                                            <?= htmlspecialchars($food['name']) ?>
                                        </span>
                                        <span style="color: var(--primary); font-weight: 700;">
                                            <?= $food['calories'] ?> kcal
                                        </span>
                                    </div>
                                    <div style="font-size: 13px; color: var(--gray);">
                                        Porción: <?= $food['portion'] ?> | 
                                        Proteína: <?= $food['protein'] ?>g | 
                                        Carbohidratos: <?= $food['carbs'] ?>g | 
                                        Grasas: <?= $food['fats'] ?>g
                                    </div>
                                    <?php if (isset($food['name_original']) && $food['name'] !== $food['name_original']): ?>
                                        <div style="font-size: 11px; color: #95a5a6; font-style: italic;">
                                            (<?= htmlspecialchars($food['name_original']) ?>)
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php else: ?>
                    <p style="color: var(--gray); text-align: center; padding: 20px;">
                        No se encontraron alimentos para este tipo de comida. Intenta generar un nuevo plan.
                    </p>
                <?php endif; ?>
            </div>

            <!-- Almuerzo -->
            <div class="meal-card">
                <div class="meal-header">
                    <div class="meal-title">
                        🌞 Almuerzo (35% - <?= $data['distribution']['lunch'] ?> kcal)
                    </div>
                    <div class="meal-calories">
                        <?= $data['mealPlan']['lunch']['totalCalories'] ?> kcal
                    </div>
                </div>

                <div class="alert alert-info" style="margin: 15px 0; font-size: 14px;">
                    💡 <strong>Ideas de almuerzo:</strong> Pollo con arroz • Pasta integral con vegetales • Lentejas • Carne con ensalada
                </div>

                <?php if (!empty($data['mealPlan']['lunch']['foods'])): ?>
                    <ul class="food-list">
                        <?php foreach ($data['mealPlan']['lunch']['foods'] as $food): ?>
                            <li class="food-item">
                                <div style="display: flex; flex-direction: column; gap: 5px; width: 100%;">
                                    <div style="display: flex; justify-content: space-between; align-items: center;">
                                        <span class="food-name" style="font-weight: 600;">
                                            <?= htmlspecialchars($food['name']) ?>
                                        </span>
                                        <span style="color: var(--primary); font-weight: 700;">
                                            <?= $food['calories'] ?> kcal
                                        </span>
                                    </div>
                                    <div style="font-size: 13px; color: var(--gray);">
                                        Porción: <?= $food['portion'] ?> | 
                                        Proteína: <?= $food['protein'] ?>g | 
                                        Carbohidratos: <?= $food['carbs'] ?>g | 
                                        Grasas: <?= $food['fats'] ?>g
                                    </div>
                                    <?php if (isset($food['name_original']) && $food['name'] !== $food['name_original']): ?>
                                        <div style="font-size: 11px; color: #95a5a6; font-style: italic;">
                                            (<?= htmlspecialchars($food['name_original']) ?>)
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php else: ?>
                    <p style="color: var(--gray); text-align: center; padding: 20px;">
                        No se encontraron alimentos para este tipo de comida. Intenta generar un nuevo plan.
                    </p>
                <?php endif; ?>
            </div>

            <!-- Cena -->
            <div class="meal-card">
                <div class="meal-header">
                    <div class="meal-title">
                        🌙 Cena (25% - <?= $data['distribution']['dinner'] ?> kcal)
                    </div>
                    <div class="meal-calories">
                        <?= $data['mealPlan']['dinner']['totalCalories'] ?> kcal
                    </div>
                </div>

                <div class="alert alert-info" style="margin: 15px 0; font-size: 14px;">
                    💡 <strong>Ideas de cena:</strong> Salmón al horno • Ensalada con pollo • Vegetales asados • Sopa ligera
                </div>

                <?php if (!empty($data['mealPlan']['dinner']['foods'])): ?>
                    <ul class="food-list">
                        <?php foreach ($data['mealPlan']['dinner']['foods'] as $food): ?>
                            <li class="food-item">
                                <div style="display: flex; flex-direction: column; gap: 5px; width: 100%;">
                                    <div style="display: flex; justify-content: space-between; align-items: center;">
                                        <span class="food-name" style="font-weight: 600;">
                                            <?= htmlspecialchars($food['name']) ?>
                                        </span>
                                        <span style="color: var(--primary); font-weight: 700;">
                                            <?= $food['calories'] ?> kcal
                                        </span>
                                    </div>
                                    <div style="font-size: 13px; color: var(--gray);">
                                        Porción: <?= $food['portion'] ?> | 
                                        Proteína: <?= $food['protein'] ?>g | 
                                        Carbohidratos: <?= $food['carbs'] ?>g | 
                                        Grasas: <?= $food['fats'] ?>g
                                    </div>
                                    <?php if (isset($food['name_original']) && $food['name'] !== $food['name_original']): ?>
                                        <div style="font-size: 11px; color: #95a5a6; font-style: italic;">
                                            (<?= htmlspecialchars($food['name_original']) ?>)
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php else: ?>
                    <p style="color: var(--gray); text-align: center; padding: 20px;">
                        No se encontraron alimentos para este tipo de comida. Intenta generar un nuevo plan.
                    </p>
                <?php endif; ?>
            </div>

            <!-- Merienda -->
            <div class="meal-card">
                <div class="meal-header">
                    <div class="meal-title">
                        🍎 Merienda (15% - <?= $data['distribution']['snack'] ?> kcal)
                    </div>
                    <div class="meal-calories">
                        <?= $data['mealPlan']['snack']['totalCalories'] ?> kcal
                    </div>
                </div>

                <div class="alert alert-info" style="margin: 15px 0; font-size: 14px;">
                    💡 <strong>Ideas de merienda:</strong> Frutas frescas • Frutos secos • Yogurt • Vegetales con hummus
                </div>

                <?php if (!empty($data['mealPlan']['snack']['foods'])): ?>
                    <ul class="food-list">
                        <?php foreach ($data['mealPlan']['snack']['foods'] as $food): ?>
                            <li class="food-item">
                                <div style="display: flex; flex-direction: column; gap: 5px; width: 100%;">
                                    <div style="display: flex; justify-content: space-between; align-items: center;">
                                        <span class="food-name" style="font-weight: 600;">
                                            <?= htmlspecialchars($food['name']) ?>
                                        </span>
                                        <span style="color: var(--primary); font-weight: 700;">
                                            <?= $food['calories'] ?> kcal
                                        </span>
                                    </div>
                                    <div style="font-size: 13px; color: var(--gray);">
                                        Porción: <?= $food['portion'] ?> | 
                                        Proteína: <?= $food['protein'] ?>g | 
                                        Carbohidratos: <?= $food['carbs'] ?>g | 
                                        Grasas: <?= $food['fats'] ?>g
                                    </div>
                                    <?php if (isset($food['name_original']) && $food['name'] !== $food['name_original']): ?>
                                        <div style="font-size: 11px; color: #95a5a6; font-style: italic;">
                                            (<?= htmlspecialchars($food['name_original']) ?>)
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php else: ?>
                    <p style="color: var(--gray); text-align: center; padding: 20px;">
                        No se encontraron alimentos para este tipo de comida. Intenta generar un nuevo plan.
                    </p>
                <?php endif; ?>
            </div>

            <div style="margin-top: 30px; text-align: center;">
                <button onclick="window.location.reload()" class="btn btn-primary">
                    🔄 Generar Nuevo Plan
                </button>
                <a href="index.php?controller=dashboard&action=index" class="btn btn-secondary">
                    ← Volver al Dashboard
                </a>
            </div>

            <div class="alert alert-info" style="margin-top: 30px;">
                <strong>💡 Tip:</strong> Este plan es una guía general. Ajusta las porciones según tu hambre y nivel de actividad. 
                Recuerda beber al menos 2 litros de agua al día.
            </div>
        </div>

    </div>

    <script src="assets/js/app.js"></script>
</body>
</html>

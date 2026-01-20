<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#2ecc71">
    <title>Mi Progreso - Control Nutricional</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="manifest" href="manifest.json">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="dashboard">
    
    <!-- Navbar -->
    <nav class="navbar">
        <div class="navbar-brand">
            🥗 Control Nutricional
        </div>
        <div class="navbar-user">
            <a href="index.php?controller=dashboard&action=index" class="btn btn-secondary">
                ← Dashboard
            </a>
        </div>
    </nav>

    <div class="container">

        <?php if (isset($_GET['success'])): ?>
            <div class="alert alert-success">
                ✅ Peso registrado exitosamente
            </div>
        <?php endif; ?>

        <!-- Progreso Actual -->
        <?php if ($data['difference']): ?>
            <div class="diet-section">
                <h2>📊 Tu Progreso</h2>
                <div class="stats-grid">
                    <div class="stat-card">
                        <h3>Peso Anterior</h3>
                        <div class="stat-value"><?= $data['difference']['previous'] ?> <small>kg</small></div>
                        <div class="stat-label">
                            Hace <?= $data['difference']['days_between'] ?> día(s)
                        </div>
                    </div>
                    <div class="stat-card">
                        <h3>Peso Actual</h3>
                        <div class="stat-value" style="color: var(--primary)">
                            <?= $data['difference']['current'] ?> <small>kg</small>
                        </div>
                        <div class="stat-label">Último registro</div>
                    </div>
                    <div class="stat-card">
                        <h3>Diferencia</h3>
                        <div class="stat-value" style="color: <?= $data['difference']['difference'] < 0 ? 'var(--primary)' : 'var(--danger)' ?>">
                            <?= $data['difference']['difference'] > 0 ? '+' : '' ?><?= $data['difference']['difference'] ?> <small>kg</small>
                        </div>
                        <div class="stat-label">
                            <?= $data['difference']['percentage'] > 0 ? '+' : '' ?><?= $data['difference']['percentage'] ?>%
                            <?php if ($data['profile']['goal'] === 'lose'): ?>
                                <?= $data['difference']['difference'] < 0 ? '🎉 ¡Muy bien!' : '⚠️ Subiste' ?>
                            <?php elseif ($data['profile']['goal'] === 'gain'): ?>
                                <?= $data['difference']['difference'] > 0 ? '🎉 ¡Muy bien!' : '⚠️ Bajaste' ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <!-- Gráfica -->
        <?php if (count($data['progress']) > 1): ?>
            <div class="diet-section">
                <h2>📈 Evolución (últimos 30 días)</h2>
                <canvas id="weightChart" style="max-height: 300px;"></canvas>
            </div>
        <?php endif; ?>

        <!-- Estadísticas Generales -->
        <?php if ($data['stats']['total_records'] > 0): ?>
            <div class="diet-section">
                <h2>📋 Estadísticas Generales</h2>
                <div class="stats-grid">
                    <div class="stat-card">
                        <h3>Peso Mínimo</h3>
                        <div class="stat-value"><?= round($data['stats']['min_weight'], 2) ?> <small>kg</small></div>
                    </div>
                    <div class="stat-card">
                        <h3>Peso Máximo</h3>
                        <div class="stat-value"><?= round($data['stats']['max_weight'], 2) ?> <small>kg</small></div>
                    </div>
                    <div class="stat-card">
                        <h3>Peso Promedio</h3>
                        <div class="stat-value"><?= round($data['stats']['avg_weight'], 2) ?> <small>kg</small></div>
                    </div>
                    <div class="stat-card">
                        <h3>Total Registros</h3>
                        <div class="stat-value"><?= $data['stats']['total_records'] ?></div>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <!-- Historial -->
        <div class="diet-section">
            <h2>📝 Historial de Pesajes</h2>
            
            <?php if (count($data['history']) > 0): ?>
                <div style="overflow-x: auto;">
                    <table style="width: 100%; border-collapse: collapse;">
                        <thead>
                            <tr style="background: var(--light);">
                                <th style="padding: 12px; text-align: left;">Fecha</th>
                                <th style="padding: 12px; text-align: center;">Peso</th>
                                <th style="padding: 12px; text-align: left;">Notas</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($data['history'] as $record): ?>
                                <tr style="border-bottom: 1px solid var(--light);">
                                    <td style="padding: 12px;">
                                        <?= date('d/m/Y H:i', strtotime($record['recorded_at'])) ?>
                                    </td>
                                    <td style="padding: 12px; text-align: center; font-weight: 600;">
                                        <?= $record['weight_kg'] ?> kg
                                    </td>
                                    <td style="padding: 12px; color: var(--gray);">
                                        <?= $record['notes'] ? htmlspecialchars($record['notes']) : '-' ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="alert alert-info">
                    No tienes registros de peso aún. ¡Comienza a hacer seguimiento!
                </div>
            <?php endif; ?>

            <div style="margin-top: 30px; text-align: center;">
                <a href="index.php?controller=weight&action=add" class="btn btn-primary">
                    ⚖️ Registrar Nuevo Peso
                </a>
                <a href="index.php?controller=dashboard&action=index" class="btn btn-secondary">
                    ← Volver al Dashboard
                </a>
            </div>
        </div>

    </div>

    <?php if (count($data['progress']) > 1): ?>
    <script>
        const ctx = document.getElementById('weightChart').getContext('2d');
        const chartData = <?= json_encode($data['progress']) ?>;
        
        const labels = chartData.map(item => {
            const date = new Date(item.recorded_at);
            return date.toLocaleDateString('es-ES', { day: '2-digit', month: '2-digit' });
        });
        
        const weights = chartData.map(item => parseFloat(item.weight_kg));

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Peso (kg)',
                    data: weights,
                    borderColor: '#2ecc71',
                    backgroundColor: 'rgba(46, 204, 113, 0.1)',
                    tension: 0.4,
                    fill: true,
                    pointRadius: 5,
                    pointHoverRadius: 7
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: false,
                        ticks: {
                            callback: function(value) {
                                return value + ' kg';
                            }
                        }
                    }
                }
            }
        });
    </script>
    <?php endif; ?>

    <script src="assets/js/app.js"></script>
</body>
</html>

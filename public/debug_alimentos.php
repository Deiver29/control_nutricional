<?php
require_once __DIR__ . '/../app/config/Database.php';

$db = Database::connect();

echo "<h2>🔍 Análisis Detallado</h2>";

// Ver un alimento específico y sus nutrientes
$stmt = $db->query("SELECT fdc_id, description FROM food LIMIT 1");
$food = $stmt->fetch(PDO::FETCH_ASSOC);

echo "<h3>Ejemplo de alimento:</h3>";
echo "<p><strong>FDC ID:</strong> {$food['fdc_id']}</p>";
echo "<p><strong>Nombre:</strong> " . htmlspecialchars($food['description']) . "</p>";

echo "<h3>Nutrientes de este alimento:</h3>";
$stmt = $db->prepare("SELECT nutrient_id, amount FROM food_nutrient WHERE fdc_id = ? LIMIT 20");
$stmt->execute([$food['fdc_id']]);
$nutrients = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo "<table border='1' cellpadding='5'>";
echo "<tr><th>Nutrient ID</th><th>Amount</th></tr>";
foreach ($nutrients as $nut) {
    echo "<tr><td>{$nut['nutrient_id']}</td><td>{$nut['amount']}</td></tr>";
}
echo "</table>";

// Buscar cuántos alimentos tienen nutrient_id = 1008 (energía)
echo "<h3>Análisis de Energía (1008):</h3>";
$stmt = $db->query("
    SELECT COUNT(DISTINCT fdc_id) as total 
    FROM food_nutrient 
    WHERE nutrient_id = 1008 AND amount > 0
");
$result = $stmt->fetch(PDO::FETCH_ASSOC);
echo "<p>Alimentos con energía (1008) > 0: <strong>{$result['total']}</strong></p>";

// Ver ejemplos con energía
echo "<h3>Ejemplos de alimentos con energía:</h3>";
$stmt = $db->query("
    SELECT f.fdc_id, f.description, fn.amount as energia
    FROM food f
    INNER JOIN food_nutrient fn ON f.fdc_id = fn.fdc_id
    WHERE fn.nutrient_id = 1008 AND fn.amount > 0
    LIMIT 10
");
$examples = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo "<table border='1' cellpadding='5'>";
echo "<tr><th>FDC ID</th><th>Nombre</th><th>Energía (kcal)</th></tr>";
foreach ($examples as $ex) {
    echo "<tr>";
    echo "<td>{$ex['fdc_id']}</td>";
    echo "<td>" . htmlspecialchars($ex['description']) . "</td>";
    echo "<td>{$ex['energia']}</td>";
    echo "</tr>";
}
echo "</table>";

// Botón para importar con el método correcto
echo "<div style='margin-top: 30px; padding: 20px; background: #f0f0f0; border-radius: 8px;'>";
echo "<h3>Si ves alimentos arriba con energía, haz click aquí:</h3>";
echo "<a href='importar_alimentos_fix.php' style='background: #2ecc71; color: white; padding: 15px 30px; text-decoration: none; border-radius: 8px; font-size: 18px; display: inline-block;'>✅ Importar Alimentos (Método Correcto)</a>";
echo "</div>";
?>

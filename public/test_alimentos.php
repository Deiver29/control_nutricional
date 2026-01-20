<?php
require_once __DIR__ . '/../app/config/Database.php';

$db = Database::connect();

// Verificar cuántos alimentos hay en la tabla
$stmt = $db->query("SELECT COUNT(*) as total FROM alimentos");
$result = $stmt->fetch(PDO::FETCH_ASSOC);

echo "<h2>Total de alimentos en la BD: " . $result['total'] . "</h2>";

// Ver algunos ejemplos
echo "<h3>Primeros 10 alimentos:</h3>";
$stmt = $db->query("SELECT id, nombre, categoria, energia_kcal FROM alimentos LIMIT 10");
$foods = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo "<table border='1' cellpadding='5'>";
echo "<tr><th>ID</th><th>Nombre</th><th>Categoría</th><th>Calorías</th></tr>";
foreach ($foods as $food) {
    echo "<tr>";
    echo "<td>" . $food['id'] . "</td>";
    echo "<td>" . htmlspecialchars($food['nombre']) . "</td>";
    echo "<td>" . htmlspecialchars($food['categoria']) . "</td>";
    echo "<td>" . $food['energia_kcal'] . "</td>";
    echo "</tr>";
}
echo "</table>";

// Verificar alimentos con calorías
echo "<h3>Alimentos con calorías válidas:</h3>";
$stmt = $db->query("SELECT COUNT(*) as total FROM alimentos WHERE energia_kcal > 0");
$result = $stmt->fetch(PDO::FETCH_ASSOC);
echo "Total: " . $result['total'];
?>

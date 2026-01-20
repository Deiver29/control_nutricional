<?php
require_once __DIR__ . '/../app/config/Database.php';

set_time_limit(300);
$db = Database::connect();

echo "<h2>🔍 Diagnóstico e Importación de Alimentos</h2>";

// 1. Verificar qué hay en las tablas
echo "<h3>📊 Estado de las tablas:</h3>";

try {
    $stmt = $db->query("SELECT COUNT(*) as total FROM food");
    $count = $stmt->fetch(PDO::FETCH_ASSOC);
    echo "<p>✅ Tabla 'food': <strong>{$count['total']}</strong> registros</p>";
} catch (Exception $e) {
    echo "<p>❌ Error con tabla 'food': " . $e->getMessage() . "</p>";
    exit;
}

try {
    $stmt = $db->query("SELECT COUNT(*) as total FROM food_nutrient");
    $count = $stmt->fetch(PDO::FETCH_ASSOC);
    echo "<p>✅ Tabla 'food_nutrient': <strong>{$count['total']}</strong> registros</p>";
} catch (Exception $e) {
    echo "<p>❌ Error con tabla 'food_nutrient': " . $e->getMessage() . "</p>";
}

try {
    $stmt = $db->query("SELECT COUNT(*) as total FROM alimentos");
    $count = $stmt->fetch(PDO::FETCH_ASSOC);
    echo "<p>📦 Tabla 'alimentos': <strong>{$count['total']}</strong> registros (antes de importar)</p>";
} catch (Exception $e) {
    echo "<p>❌ Error con tabla 'alimentos': " . $e->getMessage() . "</p>";
}

// 2. Verificar qué nutrient_id existen realmente
echo "<h3>🔬 Nutrientes disponibles:</h3>";
$stmt = $db->query("SELECT DISTINCT nutrient_id FROM food_nutrient ORDER BY nutrient_id LIMIT 20");
$nutrients = $stmt->fetchAll(PDO::FETCH_COLUMN);
echo "<p>IDs encontrados: " . implode(", ", $nutrients) . "</p>";

// 3. Método simple: insertar alimento por alimento
echo "<h3>⏳ Iniciando importación...</h3>";

$inserted = 0;
$limit = 500;

try {
    // Obtener alimentos básicos de food
    $stmt = $db->query("SELECT fdc_id, description, food_category_id FROM food LIMIT $limit");
    $foods = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo "<p>Encontrados " . count($foods) . " alimentos para procesar...</p>";
    
    foreach ($foods as $food) {
        $fdc_id = $food['fdc_id'];
        $nombre = $food['description'];
        
        // Obtener categoría
        $categoria = 'General';
        if ($food['food_category_id']) {
            $stmtCat = $db->prepare("SELECT description FROM food_category WHERE id = ?");
            $stmtCat->execute([$food['food_category_id']]);
            $cat = $stmtCat->fetch(PDO::FETCH_ASSOC);
            if ($cat) {
                $categoria = $cat['description'];
            }
        }
        
        // Buscar nutrientes para este alimento
        $stmtNut = $db->prepare("SELECT nutrient_id, amount FROM food_nutrient WHERE fdc_id = ?");
        $stmtNut->execute([$fdc_id]);
        $nutrients = $stmtNut->fetchAll(PDO::FETCH_ASSOC);
        
        $energia = null;
        $proteina = null;
        $carbos = null;
        $grasas = null;
        $fibra = null;
        
        foreach ($nutrients as $nut) {
            switch ($nut['nutrient_id']) {
                case 1008: $energia = $nut['amount']; break;
                case 1003: $proteina = $nut['amount']; break;
                case 1005: $carbos = $nut['amount']; break;
                case 1004: $grasas = $nut['amount']; break;
                case 1079: $fibra = $nut['amount']; break;
            }
        }
        
        // Solo insertar si tiene calorías
        if ($energia !== null && $energia > 0) {
            $stmtInsert = $db->prepare("
                INSERT INTO alimentos (fdc_id, nombre, categoria, energia_kcal, proteina_g, carbohidratos_g, grasas_g, fibra_g, fuente)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'USDA')
            ");
            
            $stmtInsert->execute([
                $fdc_id,
                $nombre,
                $categoria,
                $energia,
                $proteina,
                $carbos,
                $grasas,
                $fibra
            ]);
            
            $inserted++;
        }
    }
    
    echo "<p style='color: green; font-weight: bold; font-size: 18px;'>✅ Importación completada: $inserted alimentos agregados</p>";
    
    // Verificar resultado
    $stmt = $db->query("SELECT COUNT(*) as total FROM alimentos");
    $count = $stmt->fetch(PDO::FETCH_ASSOC);
    echo "<p style='font-size: 16px;'>📦 Total en tabla 'alimentos': <strong>{$count['total']}</strong></p>";
    
    // Mostrar ejemplos
    echo "<h3>🍽️ Ejemplos de alimentos importados:</h3>";
    $stmt = $db->query("SELECT nombre, categoria, energia_kcal, proteina_g, carbohidratos_g, grasas_g FROM alimentos LIMIT 15");
    $examples = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    if (count($examples) > 0) {
        echo "<table border='1' cellpadding='8' style='border-collapse: collapse; width: 100%;'>";
        echo "<tr style='background: #2ecc71; color: white;'>";
        echo "<th>Nombre</th><th>Categoría</th><th>Calorías</th><th>Proteínas</th><th>Carbos</th><th>Grasas</th>";
        echo "</tr>";
        
        foreach ($examples as $ex) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($ex['nombre']) . "</td>";
            echo "<td>" . htmlspecialchars($ex['categoria']) . "</td>";
            echo "<td>" . round($ex['energia_kcal'], 1) . " kcal</td>";
            echo "<td>" . round($ex['proteina_g'] ?? 0, 1) . " g</td>";
            echo "<td>" . round($ex['carbohidratos_g'] ?? 0, 1) . " g</td>";
            echo "<td>" . round($ex['grasas_g'] ?? 0, 1) . " g</td>";
            echo "</tr>";
        }
        echo "</table>";
        
        echo "<div style='margin-top: 30px; text-align: center;'>";
        echo "<a href='index.php?controller=diet&action=generate' style='background: #2ecc71; color: white; padding: 15px 30px; text-decoration: none; border-radius: 8px; font-size: 18px; display: inline-block;'>🍽️ ¡Generar Mi Dieta Ahora!</a>";
        echo "</div>";
    }
    
} catch (Exception $e) {
    echo "<p style='color: red; font-weight: bold;'>❌ Error durante la importación: " . $e->getMessage() . "</p>";
}
?>

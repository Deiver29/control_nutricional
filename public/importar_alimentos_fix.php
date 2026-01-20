<?php
require_once __DIR__ . '/../app/config/Database.php';

set_time_limit(300);
$db = Database::connect();

echo "<h2>🍽️ Importación de Alimentos (Método Optimizado)</h2>";

$inserted = 0;
$limit = 1000;

try {
    // Método directo: usar INNER JOIN para asegurar que tienen energía
    $stmt = $db->query("
        SELECT DISTINCT
            f.fdc_id,
            f.description as nombre,
            f.food_category_id
        FROM food f
        INNER JOIN food_nutrient fn ON f.fdc_id = fn.fdc_id
        WHERE fn.nutrient_id = 1008 
        AND fn.amount > 0
        LIMIT $limit
    ");
    
    $foods = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo "<p>✅ Encontrados <strong>" . count($foods) . "</strong> alimentos con calorías</p>";
    echo "<p>⏳ Procesando...</p>";
    
    foreach ($foods as $food) {
        $fdc_id = $food['fdc_id'];
        $nombre = $food['nombre'];
        
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
        
        // Obtener todos los nutrientes de una vez
        $stmtNut = $db->prepare("
            SELECT nutrient_id, amount 
            FROM food_nutrient 
            WHERE fdc_id = ? 
            AND nutrient_id IN (1003, 1004, 1005, 1008, 1079)
        ");
        $stmtNut->execute([$fdc_id]);
        $nutrients = $stmtNut->fetchAll(PDO::FETCH_ASSOC);
        
        $energia = 0;
        $proteina = 0;
        $carbos = 0;
        $grasas = 0;
        $fibra = 0;
        
        foreach ($nutrients as $nut) {
            switch ($nut['nutrient_id']) {
                case 1008: $energia = $nut['amount']; break;
                case 1003: $proteina = $nut['amount']; break;
                case 1005: $carbos = $nut['amount']; break;
                case 1004: $grasas = $nut['amount']; break;
                case 1079: $fibra = $nut['amount']; break;
            }
        }
        
        // Insertar (ya sabemos que tiene energía > 0)
        try {
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
            
            // Mostrar progreso cada 100
            if ($inserted % 100 == 0) {
                echo "<p>📦 Importados: $inserted alimentos...</p>";
                flush();
            }
            
        } catch (Exception $e) {
            // Probablemente duplicado, continuar
            continue;
        }
    }
    
    echo "<div style='background: #2ecc71; color: white; padding: 20px; border-radius: 8px; margin: 20px 0;'>";
    echo "<h2 style='margin: 0;'>✅ Importación Completada</h2>";
    echo "<h3 style='margin: 10px 0 0 0;'>$inserted alimentos agregados exitosamente</h3>";
    echo "</div>";
    
    // Verificar resultado
    $stmt = $db->query("SELECT COUNT(*) as total FROM alimentos");
    $count = $stmt->fetch(PDO::FETCH_ASSOC);
    echo "<p style='font-size: 18px;'>📦 <strong>Total en tabla 'alimentos':</strong> {$count['total']}</p>";
    
    // Mostrar ejemplos
    echo "<h3>🍽️ Ejemplos de alimentos importados:</h3>";
    $stmt = $db->query("
        SELECT nombre, categoria, energia_kcal, proteina_g, carbohidratos_g, grasas_g 
        FROM alimentos 
        ORDER BY RAND()
        LIMIT 20
    ");
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
        
        echo "<div style='margin-top: 40px; text-align: center; background: #f8f9fa; padding: 30px; border-radius: 10px;'>";
        echo "<h2 style='color: #2ecc71;'>🎉 ¡Listo para generar dietas!</h2>";
        echo "<p style='font-size: 16px; color: #666;'>Ya tienes $inserted alimentos en tu base de datos</p>";
        echo "<a href='index.php?controller=diet&action=generate' style='background: #2ecc71; color: white; padding: 15px 40px; text-decoration: none; border-radius: 8px; font-size: 20px; display: inline-block; margin-top: 20px;'>🍽️ ¡Generar Mi Primera Dieta!</a>";
        echo "</div>";
    }
    
} catch (Exception $e) {
    echo "<div style='background: #e74c3c; color: white; padding: 20px; border-radius: 8px;'>";
    echo "<h3>❌ Error durante la importación</h3>";
    echo "<p>" . $e->getMessage() . "</p>";
    echo "</div>";
}
?>

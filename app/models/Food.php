<?php
require_once __DIR__ . '/../config/Database.php';

class Food {

    public static function getRandomByCategory($category, $limit = 5) {
        $db = Database::connect();
        $stmt = $db->prepare(
            "SELECT * FROM alimentos 
             WHERE categoria LIKE ? AND energia_kcal IS NOT NULL 
             ORDER BY RAND() LIMIT ?"
        );
        $stmt->execute(["%$category%", $limit]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function searchByCalories($minCal, $maxCal, $limit = 10) {
        $db = Database::connect();
        $stmt = $db->prepare(
            "SELECT * FROM alimentos 
             WHERE energia_kcal BETWEEN ? AND ? 
             AND energia_kcal IS NOT NULL
             ORDER BY RAND() LIMIT ?"
        );
        $stmt->execute([$minCal, $maxCal, $limit]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getByCategory($category) {
        $db = Database::connect();
        $stmt = $db->prepare(
            "SELECT * FROM alimentos 
             WHERE categoria LIKE ? 
             AND energia_kcal IS NOT NULL
             ORDER BY energia_kcal ASC"
        );
        $stmt->execute(["%$category%"]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getAllCategories() {
        $db = Database::connect();
        $stmt = $db->query(
            "SELECT DISTINCT categoria FROM alimentos 
             WHERE categoria IS NOT NULL 
             ORDER BY categoria"
        );
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    public static function getRecommendedFoods($calorieTarget, $mealType = 'all') {
        $db = Database::connect();
        
        // Rango de calorías por porción
        $minCal = 20;
        $maxCal = 400;

        // Semilla aleatoria
        $randomSeed = time() + rand(1, 1000);

        // Primero intentar con filtros específicos
        $categoryFilter = "";
        
        switch($mealType) {
            case 'breakfast':
                $categoryFilter = "AND (categoria LIKE '%Dairy%' OR categoria LIKE '%Cereal%' OR 
                                  categoria LIKE '%Fruit%' OR categoria LIKE '%Baked%')";
                break;
            case 'lunch':
                $categoryFilter = "AND (categoria LIKE '%Poultry%' OR categoria LIKE '%Beef%' OR 
                                  categoria LIKE '%Vegetables%' OR categoria LIKE '%Legumes%')";
                break;
            case 'dinner':
                $categoryFilter = "AND (categoria LIKE '%Fish%' OR categoria LIKE '%Poultry%' OR 
                                  categoria LIKE '%Vegetables%' OR categoria LIKE '%Seafood%')";
                break;
            case 'snack':
                $categoryFilter = "AND (categoria LIKE '%Fruit%' OR categoria LIKE '%Nut%' OR 
                                  categoria LIKE '%Dairy%' OR categoria LIKE '%Snack%')";
                break;
        }

        // Intentar con filtro específico
        $query = "SELECT * FROM alimentos 
                  WHERE energia_kcal BETWEEN ? AND ?
                  AND energia_kcal IS NOT NULL
                  AND energia_kcal > 0
                  $categoryFilter
                  ORDER BY RAND($randomSeed) 
                  LIMIT 50";

        $stmt = $db->prepare($query);
        $stmt->execute([$minCal, $maxCal]);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Si no hay resultados, buscar sin filtro de categoría
        if (empty($results)) {
            $query = "SELECT * FROM alimentos 
                      WHERE energia_kcal BETWEEN ? AND ?
                      AND energia_kcal IS NOT NULL
                      AND energia_kcal > 0
                      ORDER BY RAND($randomSeed) 
                      LIMIT 50";
            $stmt = $db->prepare($query);
            $stmt->execute([$minCal, $maxCal]);
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        // Si aún no hay resultados, buscar cualquier alimento
        if (empty($results)) {
            $query = "SELECT * FROM alimentos 
                      WHERE energia_kcal > 0
                      ORDER BY RAND($randomSeed) 
                      LIMIT 50";
            $stmt = $db->prepare($query);
            $stmt->execute();
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        return $results;
    }

    public static function getBreakfastRecommendations($calories) {
        return [
            'suggestions' => [
                '🥣 Avena con frutas y nueces',
                '🍳 Huevos revueltos con tostadas integrales',
                '🥛 Yogurt griego con granola y fresas',
                '🥞 Panqueques de avena con miel',
                '🥑 Tostada de aguacate con huevo'
            ],
            'tips' => 'El desayuno debe incluir proteínas, carbohidratos complejos y algo de grasa saludable.'
        ];
    }

    public static function getLunchRecommendations($calories) {
        return [
            'suggestions' => [
                '🍗 Pechuga de pollo a la plancha con arroz y vegetales',
                '🥩 Carne magra con ensalada y papas al horno',
                '🍝 Pasta integral con salsa de tomate y vegetales',
                '🌮 Tacos de pescado con ensalada fresca',
                '🍲 Lentejas con arroz y vegetales salteados'
            ],
            'tips' => 'El almuerzo debe ser tu comida más abundante. Incluye proteína, vegetales y carbohidratos.'
        ];
    }

    public static function getDinnerRecommendations($calories) {
        return [
            'suggestions' => [
                '🐟 Salmón al horno con vegetales asados',
                '🥗 Ensalada de pollo con quinoa',
                '🍤 Camarones salteados con brócoli',
                '🥘 Estofado de vegetales con tofu',
                '🍗 Pollo al limón con espárragos'
            ],
            'tips' => 'La cena debe ser ligera. Evita carbohidratos pesados en la noche.'
        ];
    }

    public static function getSnackRecommendations($calories) {
        return [
            'suggestions' => [
                '🍎 Manzana con mantequilla de maní',
                '🥜 Puñado de almendras o nueces',
                '🥤 Batido de proteína con frutas',
                '🧀 Queso bajo en grasa con galletas integrales',
                '🥕 Bastones de zanahoria con hummus'
            ],
            'tips' => 'Las meriendas deben ser pequeñas y nutritivas. Evita azúcares refinados.'
        ];
    }
}

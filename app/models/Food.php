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
        
        // Categorías específicas según tipo de comida
        $categoryFilters = [
            'breakfast' => "AND (categoria LIKE '%Dairy%' OR categoria LIKE '%Cereal%' OR 
                            categoria LIKE '%Fruits%' OR categoria LIKE '%Baked%' OR 
                            categoria LIKE '%Egg%' OR nombre LIKE '%egg%' OR
                            nombre LIKE '%bread%' OR nombre LIKE '%milk%' OR
                            nombre LIKE '%yogurt%' OR nombre LIKE '%oat%')",
            'lunch' => "AND (categoria LIKE '%Poultry%' OR categoria LIKE '%Beef%' OR 
                        categoria LIKE '%Vegetables%' OR categoria LIKE '%Legumes%' OR
                        categoria LIKE '%Pork%' OR nombre LIKE '%chicken%' OR
                        nombre LIKE '%rice%' OR nombre LIKE '%bean%' OR
                        nombre LIKE '%pasta%' OR nombre LIKE '%potato%')",
            'dinner' => "AND (categoria LIKE '%Fish%' OR categoria LIKE '%Poultry%' OR 
                         categoria LIKE '%Vegetables%' OR categoria LIKE '%Seafood%' OR
                         nombre LIKE '%fish%' OR nombre LIKE '%salmon%' OR
                         nombre LIKE '%tuna%' OR nombre LIKE '%vegetables%' OR
                         nombre LIKE '%salad%')",
            'snack' => "AND (categoria LIKE '%Fruits%' OR categoria LIKE '%Nuts%' OR 
                        categoria LIKE '%Dairy%' OR categoria LIKE '%Snacks%' OR
                        nombre LIKE '%fruit%' OR nombre LIKE '%nut%' OR
                        nombre LIKE '%yogurt%' OR nombre LIKE '%cheese%')"
        ];

        $categoryFilter = ($mealType !== 'all' && isset($categoryFilters[$mealType])) 
            ? $categoryFilters[$mealType] 
            : "";

        $minCal = $calorieTarget * 0.5;
        $maxCal = $calorieTarget * 1.5;

        $query = "SELECT * FROM alimentos 
                  WHERE energia_kcal BETWEEN ? AND ?
                  AND energia_kcal IS NOT NULL
                  $categoryFilter
                  ORDER BY RAND() LIMIT 30";

        $stmt = $db->prepare($query);
        $stmt->execute([$minCal, $maxCal]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
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

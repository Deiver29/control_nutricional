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
        
        // Categorías según tipo de comida
        $categories = [
            'breakfast' => ['Dairy', 'Cereal', 'Fruits', 'Baked'],
            'lunch' => ['Poultry', 'Beef', 'Vegetables', 'Legumes'],
            'dinner' => ['Fish', 'Poultry', 'Vegetables'],
            'snack' => ['Fruits', 'Nuts', 'Dairy']
        ];

        if ($mealType !== 'all' && isset($categories[$mealType])) {
            $categoryList = implode("','", $categories[$mealType]);
            $stmt = $db->prepare(
                "SELECT * FROM alimentos 
                 WHERE categoria IN ('$categoryList')
                 AND energia_kcal BETWEEN ? AND ?
                 AND energia_kcal IS NOT NULL
                 ORDER BY RAND() LIMIT 20"
            );
        } else {
            $stmt = $db->prepare(
                "SELECT * FROM alimentos 
                 WHERE energia_kcal BETWEEN ? AND ?
                 AND energia_kcal IS NOT NULL
                 ORDER BY RAND() LIMIT 20"
            );
        }

        $minCal = $calorieTarget * 0.7;
        $maxCal = $calorieTarget * 1.3;
        $stmt->execute([$minCal, $maxCal]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

<?php
require_once __DIR__ . '/../models/HealthProfile.php';
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../models/Food.php';
require_once __DIR__ . '/../helpers/FoodTranslator.php';

class DietController {

    public function generate() {
        // Verificar autenticación
        if (!isset($_SESSION['user_id'])) {
            header("Location: index.php");
            exit;
        }

        $user = User::findById($_SESSION['user_id']);
        $profile = HealthProfile::findByUserId($_SESSION['user_id']);

        if (!$profile) {
            header("Location: index.php?controller=user&action=onboarding");
            exit;
        }

        // Calcular calorías totales
        $totalCalories = HealthProfile::calculateTDEE($profile);

        // Distribución de calorías por comida
        $distribution = [
            'breakfast' => round($totalCalories * 0.25),  // 25%
            'lunch' => round($totalCalories * 0.35),      // 35%
            'dinner' => round($totalCalories * 0.25),     // 25%
            'snack' => round($totalCalories * 0.15)       // 15%
        ];

        // Generar plan de alimentos
        $mealPlan = [
            'breakfast' => $this->generateMeal($distribution['breakfast'], 'breakfast'),
            'lunch' => $this->generateMeal($distribution['lunch'], 'lunch'),
            'dinner' => $this->generateMeal($distribution['dinner'], 'dinner'),
            'snack' => $this->generateMeal($distribution['snack'], 'snack')
        ];

        $data = [
            'user' => $user,
            'profile' => $profile,
            'totalCalories' => $totalCalories,
            'distribution' => $distribution,
            'mealPlan' => $mealPlan
        ];

        require __DIR__ . '/../views/diet/plan.php';
    }

    private function generateMeal($targetCalories, $mealType) {
        $foods = Food::getRecommendedFoods($targetCalories, $mealType);
        
        $meal = [];
        $totalCal = 0;
        $itemsToAdd = rand(2, 4); // Entre 2 y 4 alimentos por comida
        $usedIndexes = [];

        // Si no hay alimentos, devolver vacío
        if (empty($foods)) {
            return [
                'foods' => [],
                'totalCalories' => 0
            ];
        }

        $caloriesPerItem = $targetCalories / $itemsToAdd;

        for ($i = 0; $i < $itemsToAdd && count($usedIndexes) < count($foods); $i++) {
            // Seleccionar alimento aleatorio que no hayamos usado
            do {
                $randomIndex = array_rand($foods);
            } while (in_array($randomIndex, $usedIndexes));
            
            $usedIndexes[] = $randomIndex;
            $randomFood = $foods[$randomIndex];
            
            // Si el alimento no tiene calorías, saltar
            if (!$randomFood['energia_kcal'] || $randomFood['energia_kcal'] <= 0) {
                continue;
            }
            
            // Calcular porción basada en calorías objetivo por item
            $portionMultiplier = $caloriesPerItem / $randomFood['energia_kcal'];
            
            // Limitar entre 30g y 300g
            $portionMultiplier = max(0.3, min($portionMultiplier, 3));
            
            $portion = round($portionMultiplier * 100); // Base 100g
            $calories = round($randomFood['energia_kcal'] * $portionMultiplier);

            $meal[] = [
                'name' => FoodTranslator::translate($randomFood['nombre']),
                'name_original' => $randomFood['nombre'],
                'portion' => $portion . 'g',
                'calories' => $calories,
                'protein' => round(($randomFood['proteina_g'] ?? 0) * $portionMultiplier, 1),
                'carbs' => round(($randomFood['carbohidratos_g'] ?? 0) * $portionMultiplier, 1),
                'fats' => round(($randomFood['grasas_g'] ?? 0) * $portionMultiplier, 1)
            ];

            $totalCal += $calories;
        }

        return [
            'foods' => $meal,
            'totalCalories' => $totalCal
        ];
    }
}

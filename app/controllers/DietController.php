<?php
require_once __DIR__ . '/../models/HealthProfile.php';
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../models/Food.php';

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
        $foods = Food::getRecommendedFoods($targetCalories / 3, $mealType);
        
        $meal = [];
        $totalCal = 0;
        $attempts = 0;

        while ($totalCal < $targetCalories && $attempts < 10 && count($foods) > 0) {
            $randomFood = $foods[array_rand($foods)];
            
            // Calcular porción para alcanzar calorías objetivo
            $remaining = $targetCalories - $totalCal;
            $portionMultiplier = min($remaining / $randomFood['energia_kcal'], 2);
            
            if ($portionMultiplier < 0.3) {
                break; // No agregar porciones muy pequeñas
            }

            $portion = round($portionMultiplier * 100); // Base 100g
            $calories = round($randomFood['energia_kcal'] * $portionMultiplier);

            $meal[] = [
                'name' => $randomFood['nombre'],
                'portion' => $portion . 'g',
                'calories' => $calories,
                'protein' => round($randomFood['proteina_g'] * $portionMultiplier, 1),
                'carbs' => round($randomFood['carbohidratos_g'] * $portionMultiplier, 1),
                'fats' => round($randomFood['grasas_g'] * $portionMultiplier, 1)
            ];

            $totalCal += $calories;
            $attempts++;
        }

        return [
            'foods' => $meal,
            'totalCalories' => $totalCal
        ];
    }
}

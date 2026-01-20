<?php
require_once __DIR__ . '/../config/Database.php';

class HealthProfile {

    public static function findByUserId($userId) {
        $db = Database::connect();
        $stmt = $db->prepare("SELECT * FROM health_profiles WHERE user_id = ?");
        $stmt->execute([$userId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function create($data) {
        $db = Database::connect();
        $stmt = $db->prepare(
            "INSERT INTO health_profiles (user_id, gender, age, height_cm, weight_kg, goal, activity) 
             VALUES (?, ?, ?, ?, ?, ?, ?)"
        );
        return $stmt->execute([
            $data['user_id'],
            $data['gender'],
            $data['age'],
            $data['height_cm'],
            $data['weight_kg'],
            $data['goal'],
            $data['activity']
        ]);
    }

    public static function update($userId, $data) {
        $db = Database::connect();
        $stmt = $db->prepare(
            "UPDATE health_profiles 
             SET gender=?, age=?, height_cm=?, weight_kg=?, goal=?, activity=?
             WHERE user_id=?"
        );
        return $stmt->execute([
            $data['gender'],
            $data['age'],
            $data['height_cm'],
            $data['weight_kg'],
            $data['goal'],
            $data['activity'],
            $userId
        ]);
    }

    public static function calculateIMC($height, $weight) {
        return round($weight / (($height / 100) ** 2), 2);
    }

    public static function getIMCStatus($imc) {
        if ($imc < 18.5) return ['status' => 'Bajo peso', 'color' => '#3498db'];
        if ($imc < 25) return ['status' => 'Peso normal', 'color' => '#2ecc71'];
        if ($imc < 30) return ['status' => 'Sobrepeso', 'color' => '#f39c12'];
        return ['status' => 'Obesidad', 'color' => '#e74c3c'];
    }

    public static function calculateTDEE($profile) {
        // Fórmula Harris-Benedict
        if ($profile['gender'] === 'M') {
            $bmr = 88.362 + (13.397 * $profile['weight_kg']) + (4.799 * $profile['height_cm']) - (5.677 * $profile['age']);
        } else {
            $bmr = 447.593 + (9.247 * $profile['weight_kg']) + (3.098 * $profile['height_cm']) - (4.330 * $profile['age']);
        }

        // Factor de actividad
        $activityFactors = [
            'low' => 1.2,
            'medium' => 1.55,
            'high' => 1.9
        ];

        $tdee = $bmr * $activityFactors[$profile['activity']];

        // Ajustar según objetivo
        if ($profile['goal'] === 'lose') {
            $tdee -= 500; // Déficit de 500 kcal
        } elseif ($profile['goal'] === 'gain') {
            $tdee += 500; // Superávit de 500 kcal
        }

        return round($tdee);
    }
}

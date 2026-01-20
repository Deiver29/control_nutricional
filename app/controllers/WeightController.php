<?php
require_once __DIR__ . '/../models/WeightHistory.php';
require_once __DIR__ . '/../models/HealthProfile.php';

class WeightController {

    public function add() {
        // Verificar autenticación
        if (!isset($_SESSION['user_id'])) {
            header("Location: index.php");
            exit;
        }

        $error = null;
        $success = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $weight = (float)$_POST['weight_kg'];
            $notes = $_POST['notes'] ?? null;

            if ($weight < 20 || $weight > 300) {
                $error = "Por favor ingresa un peso válido (20-300 kg)";
            } else {
                // Guardar en historial
                WeightHistory::create($_SESSION['user_id'], $weight, $notes);

                // Actualizar peso actual en perfil
                $profile = HealthProfile::findByUserId($_SESSION['user_id']);
                if ($profile) {
                    HealthProfile::update($_SESSION['user_id'], [
                        'gender' => $profile['gender'],
                        'age' => $profile['age'],
                        'height_cm' => $profile['height_cm'],
                        'weight_kg' => $weight,
                        'goal' => $profile['goal'],
                        'activity' => $profile['activity']
                    ]);
                }

                header("Location: index.php?controller=weight&action=history&success=1");
                exit;
            }
        }

        require __DIR__ . '/../views/weight/add.php';
    }

    public function history() {
        // Verificar autenticación
        if (!isset($_SESSION['user_id'])) {
            header("Location: index.php");
            exit;
        }

        $history = WeightHistory::findByUserId($_SESSION['user_id'], 30);
        $progress = WeightHistory::getProgress($_SESSION['user_id'], 30);
        $difference = WeightHistory::calculateDifference($_SESSION['user_id']);
        $stats = WeightHistory::getStats($_SESSION['user_id']);
        $profile = HealthProfile::findByUserId($_SESSION['user_id']);

        $data = [
            'history' => $history,
            'progress' => $progress,
            'difference' => $difference,
            'stats' => $stats,
            'profile' => $profile
        ];

        require __DIR__ . '/../views/weight/history.php';
    }
}

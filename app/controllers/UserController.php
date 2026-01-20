<?php
require_once __DIR__ . '/../models/HealthProfile.php';

class UserController {

    public function onboarding() {
        // Verificar autenticación
        if (!isset($_SESSION['user_id'])) {
            header("Location: index.php");
            exit;
        }

        $error = null;
        $success = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Validar datos
            if (empty($_POST['gender']) || empty($_POST['age']) || empty($_POST['height_cm']) || 
                empty($_POST['weight_kg']) || empty($_POST['goal']) || empty($_POST['activity'])) {
                $error = "Por favor completa todos los campos";
            } else {
                $data = [
                    'user_id' => $_SESSION['user_id'],
                    'gender' => $_POST['gender'],
                    'age' => (int)$_POST['age'],
                    'height_cm' => (float)$_POST['height_cm'],
                    'weight_kg' => (float)$_POST['weight_kg'],
                    'goal' => $_POST['goal'],
                    'activity' => $_POST['activity']
                ];

                // Verificar si ya existe perfil
                $existing = HealthProfile::findByUserId($_SESSION['user_id']);
                
                if ($existing) {
                    HealthProfile::update($_SESSION['user_id'], $data);
                } else {
                    HealthProfile::create($data);
                }

                header("Location: index.php?controller=dashboard&action=index");
                exit;
            }
        }

        require __DIR__ . '/../views/onboarding/personal_data.php';
    }
}

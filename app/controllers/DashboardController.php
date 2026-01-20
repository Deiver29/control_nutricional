<?php
require_once __DIR__ . '/../models/HealthProfile.php';
require_once __DIR__ . '/../models/User.php';

class DashboardController {

    public function index() {
        // Verificar autenticación
        if (!isset($_SESSION['user_id'])) {
            header("Location: index.php");
            exit;
        }

        $user = User::findById($_SESSION['user_id']);
        $profile = HealthProfile::findByUserId($_SESSION['user_id']);

        // Si no tiene perfil, redirigir a onboarding
        if (!$profile) {
            header("Location: index.php?controller=user&action=onboarding");
            exit;
        }

        // Calcular IMC
        $imc = HealthProfile::calculateIMC($profile['height_cm'], $profile['weight_kg']);
        $imcStatus = HealthProfile::getIMCStatus($imc);

        // Calcular calorías diarias
        $tdee = HealthProfile::calculateTDEE($profile);

        // Datos para la vista
        $data = [
            'user' => $user,
            'profile' => $profile,
            'imc' => $imc,
            'imcStatus' => $imcStatus,
            'tdee' => $tdee
        ];

        require __DIR__ . '/../views/dashboard/index.php';
    }
}

<?php
require_once __DIR__ . '/../models/HealthProfile.php';
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../models/Consejo.php';

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

        // Convertir objetivo de inglés a español para los consejos
        $objetivoMap = [
            'lose' => 'bajar',
            'maintain' => 'mantener',
            'gain' => 'subir'
        ];
        $objetivoEspanol = $objetivoMap[$profile['goal']] ?? 'mantener';

        // Obtener consejo inteligente del día
        $consejoModel = new Consejo();
        $consejo = $consejoModel->obtenerConsejoAleatorio($objetivoEspanol, $imc);
        
        // Obtener consejos variados (uno de cada tipo)
        $consejosVariados = $consejoModel->obtenerConsejosVariados($objetivoEspanol, $imc);

        // Datos para la vista
        $data = [
            'user' => $user,
            'profile' => $profile,
            'imc' => $imc,
            'imcStatus' => $imcStatus,
            'tdee' => $tdee,
            'consejo' => $consejo,
            'consejosVariados' => $consejosVariados
        ];

        require __DIR__ . '/../views/dashboard/index.php';
    }
}

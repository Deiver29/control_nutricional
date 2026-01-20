<?php
require_once __DIR__ . '/../models/User.php';

class AuthController {

    public function login() {
        $error = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user = User::findByEmail($_POST['email']);

            if ($user && password_verify($_POST['password'], $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['name'];
                
                // Verificar si tiene perfil de salud
                require_once __DIR__ . '/../models/HealthProfile.php';
                $profile = HealthProfile::findByUserId($user['id']);
                
                if ($profile) {
                    header("Location: index.php?controller=dashboard&action=index");
                } else {
                    header("Location: index.php?controller=user&action=onboarding");
                }
                exit;
            }

            $error = "Credenciales incorrectas";
        }

        require __DIR__ . '/../views/auth/login.php';
    }

    public function register() {
        $error = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Validar que el email no exista
            if (User::findByEmail($_POST['email'])) {
                $error = "Este email ya está registrado";
            } else {
                User::create(
                    $_POST['name'],
                    $_POST['email'],
                    $_POST['password']
                );
                header("Location: index.php?controller=auth&action=login");
                exit;
            }
        }

        require __DIR__ . '/../views/auth/register.php';
    }

    public function logout() {
        session_destroy();
        header("Location: index.php");
        exit;
    }
}

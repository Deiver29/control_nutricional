// ===================================
// REGISTRO DEL SERVICE WORKER (PWA)
// ===================================
if ('serviceWorker' in navigator) {
    window.addEventListener('load', () => {
        navigator.serviceWorker.register('service-worker.js')
            .then(registration => {
                console.log('✅ Service Worker registrado:', registration.scope);
            })
            .catch(error => {
                console.log('❌ Error al registrar Service Worker:', error);
            });
    });
}

// ===================================
// INSTALACIÓN DE PWA
// ===================================
let deferredPrompt;
const installButton = document.getElementById('install-button');

window.addEventListener('beforeinstallprompt', (e) => {
    // Prevenir el mini-infobar automático
    e.preventDefault();
    deferredPrompt = e;
    
    // Mostrar botón de instalación personalizado
    if (installButton) {
        installButton.style.display = 'block';
    }
});

if (installButton) {
    installButton.addEventListener('click', async () => {
        if (deferredPrompt) {
            deferredPrompt.prompt();
            const { outcome } = await deferredPrompt.userChoice;
            console.log(`User response: ${outcome}`);
            deferredPrompt = null;
            installButton.style.display = 'none';
        }
    });
}

// ===================================
// VALIDACIÓN DE FORMULARIOS
// ===================================
document.addEventListener('DOMContentLoaded', () => {
    
    // Validar formulario de onboarding
    const onboardingForm = document.querySelector('.onboarding-card form');
    if (onboardingForm) {
        onboardingForm.addEventListener('submit', (e) => {
            const age = document.getElementById('age').value;
            const height = document.getElementById('height_cm').value;
            const weight = document.getElementById('weight_kg').value;
            
            if (age < 10 || age > 120) {
                e.preventDefault();
                alert('Por favor ingresa una edad válida (10-120 años)');
                return false;
            }
            
            if (height < 50 || height > 250) {
                e.preventDefault();
                alert('Por favor ingresa una altura válida (50-250 cm)');
                return false;
            }
            
            if (weight < 20 || weight > 300) {
                e.preventDefault();
                alert('Por favor ingresa un peso válido (20-300 kg)');
                return false;
            }
        });
    }

    // Validar formulario de registro
    const registerForm = document.querySelector('form[action*="register"]');
    if (registerForm) {
        registerForm.addEventListener('submit', (e) => {
            const password = document.getElementById('password').value;
            
            if (password.length < 6) {
                e.preventDefault();
                alert('La contraseña debe tener al menos 6 caracteres');
                return false;
            }
        });
    }

});

// ===================================
// ANIMACIONES Y EFECTOS
// ===================================
// Animación de entrada para las tarjetas
const observerOptions = {
    threshold: 0.1,
    rootMargin: '0px 0px -100px 0px'
};

const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.style.opacity = '1';
            entry.target.style.transform = 'translateY(0)';
        }
    });
}, observerOptions);

// Aplicar animación a tarjetas
document.addEventListener('DOMContentLoaded', () => {
    const cards = document.querySelectorAll('.stat-card, .meal-card, .diet-section');
    cards.forEach(card => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';
        card.style.transition = 'all 0.5s ease';
        observer.observe(card);
    });
});

// ===================================
// MODO OFFLINE
// ===================================
window.addEventListener('online', () => {
    console.log('✅ Conexión restaurada');
    const offlineMsg = document.getElementById('offline-message');
    if (offlineMsg) offlineMsg.remove();
});

window.addEventListener('offline', () => {
    console.log('📡 Sin conexión - Modo offline');
    if (!document.getElementById('offline-message')) {
        const message = document.createElement('div');
        message.id = 'offline-message';
        message.style.cssText = 'position:fixed;top:0;left:0;right:0;background:#e74c3c;color:white;padding:10px;text-align:center;z-index:9999;';
        message.textContent = '📡 Sin conexión - Trabajando en modo offline';
        document.body.prepend(message);
    }
});

// ===================================
// UTILIDADES
// ===================================
// Scroll suave
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
            target.scrollIntoView({ behavior: 'smooth' });
        }
    });
});

# 🥗 Control Nutricional - PWA

Aplicación web progresiva (PWA) para control nutricional personalizado con planes de dieta.

## 🚀 Características

- ✅ **Autenticación completa** (Login/Registro)
- ✅ **Perfil de salud personalizado** (edad, peso, altura, género)
- ✅ **Cálculo de IMC** (Índice de Masa Corporal)
- ✅ **Recomendaciones basadas en objetivos** (bajar/mantener/subir peso)
- ✅ **Planes de alimentación diarios** (desayuno, almuerzo, cena, meriendas)
- ✅ **Cálculo de TDEE** (Total Daily Energy Expenditure)
- ✅ **Generación automática de dietas** basada en base de datos USDA
- ✅ **PWA completa** (funciona offline, instalable)

## 🛠️ Tecnologías

- **Backend**: PHP (MVC puro)
- **Base de datos**: MySQL
- **Frontend**: HTML5, CSS3, JavaScript vanilla
- **PWA**: Service Worker, Web Manifest

## 📁 Estructura del Proyecto

```
control_nutricional/
│
├── app/
│   ├── config/
│   │   └── Database.php
│   ├── controllers/
│   │   ├── AuthController.php
│   │   ├── UserController.php
│   │   ├── DashboardController.php
│   │   └── DietController.php
│   ├── models/
│   │   ├── User.php
│   │   ├── HealthProfile.php
│   │   └── Food.php
│   └── views/
│       ├── auth/
│       │   ├── login.php
│       │   └── register.php
│       ├── onboarding/
│       │   └── personal_data.php
│       ├── dashboard/
│       │   └── index.php
│       └── diet/
│           └── plan.php
│
├── public/
│   ├── index.php
│   ├── manifest.json
│   ├── service-worker.js
│   └── assets/
│       ├── css/
│       │   └── style.css
│       ├── js/
│       │   └── app.js
│       └── icons/
│
└── .htaccess
```

## ⚙️ Instalación

### 1. Requisitos previos
- XAMPP (Apache + MySQL + PHP)
- Base de datos `control_nutricional` creada
- Tablas: `users`, `health_profiles`, `alimentos`, `food`, etc.

### 2. Configuración

1. Clonar/copiar el proyecto en `C:\xampp\htdocs\control_nutricional`

2. Verificar configuración de base de datos en `app/config/Database.php`:
```php
private static $host = "localhost";
private static $db   = "control_nutricional";
private static $user = "root";
private static $pass = "";
```

3. Iniciar Apache y MySQL desde XAMPP Control Panel

4. Acceder a: `http://localhost:8080/control_nutricional/public/index.php`

## 🎯 Flujo de la Aplicación

1. **Registro/Login** → Usuario crea cuenta o inicia sesión
2. **Onboarding** → Completa perfil (edad, peso, altura, objetivo, actividad)
3. **Dashboard** → Ve su IMC, estado de salud, calorías recomendadas
4. **Plan de Dieta** → Genera plan diario personalizado (4 comidas)
5. **Regenerar** → Puede generar nuevos planes cuantas veces quiera

## 📊 Base de Datos

### Tablas principales:

**users**
- id, name, email, password, created_at

**health_profiles**
- user_id, gender, age, height_cm, weight_kg, goal, activity

**alimentos** (desde USDA)
- id, fdc_id, nombre, categoria, energia_kcal, proteina_g, carbohidratos_g, grasas_g, fibra_g

## 🧮 Cálculos

### IMC (Índice de Masa Corporal)
```php
IMC = peso_kg / (altura_m²)
```

### TDEE (Total Daily Energy Expenditure)
Usa fórmula Harris-Benedict:
- **Hombres**: BMR = 88.362 + (13.397 × peso) + (4.799 × altura) - (5.677 × edad)
- **Mujeres**: BMR = 447.593 + (9.247 × peso) + (3.098 × altura) - (4.330 × edad)

Multiplicado por factor de actividad:
- Sedentario: 1.2
- Moderado: 1.55
- Activo: 1.9

### Distribución de calorías:
- Desayuno: 25%
- Almuerzo: 35%
- Cena: 25%
- Merienda: 15%

## 📱 PWA (Progressive Web App)

La aplicación es instalable como app nativa:

1. **Chrome/Edge**: Icono de instalación en la barra de direcciones
2. **Móvil**: "Agregar a pantalla de inicio"
3. **Funciona offline**: Service Worker cachea recursos

## 🔐 Seguridad

- ✅ Passwords hasheados con `password_hash()` (bcrypt)
- ✅ Consultas preparadas (PDO) contra SQL injection
- ✅ Validación de sesiones
- ✅ Sanitización de inputs con `htmlspecialchars()`

## 🎨 Estilos

- Diseño moderno y responsivo
- Gradientes y animaciones suaves
- Modo móvil optimizado
- Tema principal: Verde (#2ecc71)

## 📝 URLs principales

```
http://localhost:8080/control_nutricional/public/index.php                                  → Login
http://localhost:8080/control_nutricional/public/index.php?controller=auth&action=register  → Registro
http://localhost:8080/control_nutricional/public/index.php?controller=user&action=onboarding → Completar perfil
http://localhost:8080/control_nutricional/public/index.php?controller=dashboard&action=index → Dashboard
http://localhost:8080/control_nutricional/public/index.php?controller=diet&action=generate   → Plan de dieta
http://localhost:8080/control_nutricional/public/index.php?controller=auth&action=logout     → Cerrar sesión
```

## 🚀 Próximas mejoras

- [ ] Historial de peso
- [ ] Gráficas de progreso
- [ ] Recetas detalladas
- [ ] Scanner de códigos de barras
- [ ] Integración con wearables
- [ ] Recordatorios push
- [ ] Modo oscuro

## 👨‍💻 Autor

Control Nutricional v1.0 - 2026

---

¡Disfruta de tu viaje hacia una vida más saludable! 🎉

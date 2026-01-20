-- Tabla de consejos para simulación de IA
CREATE TABLE IF NOT EXISTS consejos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    tipo ENUM('ejercicio','nutricion','motivacion') NOT NULL,
    objetivo ENUM('bajar','subir','mantener') NOT NULL,
    imc_min DECIMAL(4,2) NOT NULL,
    imc_max DECIMAL(4,2) NOT NULL,
    mensaje TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ============================================
-- CONSEJOS PARA BAJAR DE PESO
-- ============================================

-- Ejercicio para bajar (IMC 25-29.9 - Sobrepeso)
INSERT INTO consejos (tipo, objetivo, imc_min, imc_max, mensaje) VALUES
('ejercicio','bajar',25.00,29.99,'Realiza caminatas de 30 minutos diarios. Es un ejercicio de bajo impacto perfecto para comenzar.'),
('ejercicio','bajar',25.00,29.99,'Prueba con ejercicios en el agua como natación o aquagym. Son ideales para proteger tus articulaciones.'),
('ejercicio','bajar',25.00,29.99,'Incorpora entrenamientos de intervalos: 1 minuto rápido, 2 minutos suave. Quema más calorías.'),
('ejercicio','bajar',25.00,29.99,'Sube escaleras en lugar del elevador. Son 10 calorías extra por minuto.'),
('ejercicio','bajar',25.00,29.99,'Practica yoga o pilates 3 veces por semana. Mejora flexibilidad y quema calorías.'),
('ejercicio','bajar',25.00,29.99,'Intenta bailar 30 minutos. Es divertido y quemas hasta 200 calorías.'),
('ejercicio','bajar',25.00,29.99,'Usa una bicicleta estática mientras ves TV. Ejercicio sin sacrificar tu tiempo de ocio.'),
('ejercicio','bajar',25.00,29.99,'Camina después de cada comida durante 10-15 minutos. Acelera tu metabolismo.'),

-- Ejercicio para bajar (IMC 30+ - Obesidad)
INSERT INTO consejos (tipo, objetivo, imc_min, imc_max, mensaje) VALUES
('ejercicio','bajar',30.00,50.00,'Comienza con caminatas cortas de 10-15 minutos, 3 veces al día. La constancia es más importante que la intensidad.'),
('ejercicio','bajar',30.00,50.00,'Prueba ejercicios sentado: levanta piernas, mueve brazos con pesas ligeras. Cada movimiento cuenta.'),
('ejercicio','bajar',30.00,50.00,'La natación es tu mejor aliada: ejercicio completo sin presión en las articulaciones.'),
('ejercicio','bajar',30.00,50.00,'Estira cada mañana durante 10 minutos. Prepara tu cuerpo y previene lesiones.'),
('ejercicio','bajar',30.00,50.00,'Haz ejercicios de respiración profunda 5 minutos al día. Reduce estrés y mejora oxigenación.'),
('ejercicio','bajar',30.00,50.00,'Usa bandas elásticas para ejercicios de resistencia. Son suaves y efectivas.'),
('ejercicio','bajar',30.00,50.00,'Camina en el agua (piscina con poca profundidad). Resistencia natural sin impacto.'),
('ejercicio','bajar',30.00,50.00,'Practica tai chi o chi kung. Movimiento suave que fortalece cuerpo y mente.'),

-- Nutrición para bajar (IMC 25-29.9)
INSERT INTO consejos (tipo, objetivo, imc_min, imc_max, mensaje) VALUES
('nutricion','bajar',25.00,29.99,'Prioriza verduras en cada comida. Llena la mitad de tu plato con vegetales.'),
('nutricion','bajar',25.00,29.99,'Elimina bebidas azucaradas. Un refresco tiene 10 cucharadas de azúcar.'),
('nutricion','bajar',25.00,29.99,'Come proteína en cada comida: huevo, pollo, pescado o legumbres. Te mantiene saciado.'),
('nutricion','bajar',25.00,29.99,'Evita alimentos procesados. Lee las etiquetas: menos ingredientes es mejor.'),
('nutricion','bajar',25.00,29.99,'Bebe 2 litros de agua al día. A veces la sed se confunde con hambre.'),
('nutricion','bajar',25.00,29.99,'Mastica despacio y come sin distracciones. Tu cerebro tarda 20 minutos en sentir saciedad.'),
('nutricion','bajar',25.00,29.99,'Desayuna siempre. Activa tu metabolismo desde temprano.'),
('nutricion','bajar',25.00,29.99,'Reduce porciones gradualmente. Usa platos más pequeños, el cerebro se adapta.'),
('nutricion','bajar',25.00,29.99,'Come cada 3-4 horas en pequeñas porciones. Evita llegar con hambre extrema.'),
('nutricion','bajar',25.00,29.99,'Reemplaza arroz blanco por arroz integral o quinoa. Más fibra, más saciedad.'),

-- Nutrición para bajar (IMC 30+)
INSERT INTO consejos (tipo, objetivo, imc_min, imc_max, mensaje) VALUES
('nutricion','bajar',30.00,50.00,'Elimina frituras completamente. Hornea, asa o cocina al vapor tus alimentos.'),
('nutricion','bajar',30.00,50.00,'Planifica tus comidas semanalmente. Evita decisiones impulsivas de última hora.'),
('nutricion','bajar',30.00,50.00,'Lleva snacks saludables contigo: almendras, zanahoria, manzana. Previene compras de emergencia.'),
('nutricion','bajar',30.00,50.00,'Reduce el pan y pasta refinada. Opta por versiones integrales en porciones controladas.'),
('nutricion','bajar',30.00,50.00,'Come en plato pequeño y con cuchara. Te obliga a comer más despacio.'),
('nutricion','bajar',30.00,50.00,'Cena 3 horas antes de dormir. Tu cuerpo necesita tiempo para digerir.'),
('nutricion','bajar',30.00,50.00,'Aumenta el consumo de fibra: avena, chia, verduras. Te mantiene lleno por más tiempo.'),
('nutricion','bajar',30.00,50.00,'Evita comer por estrés. Identifica tus emociones y busca alternativas (caminar, llamar a un amigo).'),

-- Motivación para bajar
INSERT INTO consejos (tipo, objetivo, imc_min, imc_max, mensaje) VALUES
('motivacion','bajar',25.00,50.00,'Cada pequeño esfuerzo cuenta. La perfección no existe, la constancia sí.'),
('motivacion','bajar',25.00,50.00,'Hoy eres más fuerte que ayer. Sigue adelante, tu cuerpo te lo agradecerá.'),
('motivacion','bajar',25.00,50.00,'No se trata de ser el mejor, sino de ser mejor que ayer.'),
('motivacion','bajar',25.00,50.00,'Los cambios reales toman tiempo. Confía en el proceso.'),
('motivacion','bajar',25.00,50.00,'Celebra cada logro pequeño: una semana sin refrescos, 5 días caminando. ¡Todo suma!'),
('motivacion','bajar',25.00,50.00,'Tu salud es una inversión, no un gasto. Cada buena decisión vale oro.'),
('motivacion','bajar',25.00,50.00,'Los días difíciles pasarán. Tu determinación quedará.'),
('motivacion','bajar',25.00,50.00,'No te rindas en un mal día. Mañana es una nueva oportunidad.'),
('motivacion','bajar',25.00,50.00,'Tu cuerpo puede hacer mucho más de lo que tu mente cree. Confía en ti.'),
('motivacion','bajar',25.00,50.00,'Recuerda por qué empezaste. Tu salud, tu familia, tu felicidad lo valen.'),

-- ============================================
-- CONSEJOS PARA SUBIR DE PESO
-- ============================================

-- Ejercicio para subir (IMC bajo <18.5)
INSERT INTO consejos (tipo, objetivo, imc_min, imc_max, mensaje) VALUES
('ejercicio','subir',0.00,18.49,'Enfócate en ejercicios de fuerza: sentadillas, flexiones, peso muerto. 3 veces por semana.'),
('ejercicio','subir',0.00,18.49,'Reduce el cardio. Prioriza pesas y ejercicios de resistencia para ganar masa muscular.'),
('ejercicio','subir',0.00,18.49,'Descansa 48 horas entre entrenamientos del mismo músculo. El músculo crece en el descanso.'),
('ejercicio','subir',0.00,18.49,'Aumenta progresivamente el peso. Si puedes hacer 15 repeticiones fácil, sube el peso.'),
('ejercicio','subir',0.00,18.49,'Haz ejercicios compuestos: trabajan varios músculos a la vez, más eficientes.'),
('ejercicio','subir',0.00,18.49,'Entrena con un compañero o entrenador. La técnica correcta es crucial para ganar masa.'),
('ejercicio','subir',0.00,18.49,'Duerme 8 horas. La hormona de crecimiento se libera mientras duermes.'),

-- Nutrición para subir
INSERT INTO consejos (tipo, objetivo, imc_min, imc_max, mensaje) VALUES
('nutricion','subir',0.00,18.49,'Aumenta tu ingesta calórica en 500 kcal diarias. Come cada 2-3 horas.'),
('nutricion','subir',0.00,18.49,'Come proteínas en cada comida: huevos, carne, pollo, pescado, legumbres, lácteos.'),
('nutricion','subir',0.00,18.49,'Añade frutos secos: almendras, nueces, cacahuates. Alta densidad calórica y saludables.'),
('nutricion','subir',0.00,18.49,'Incluye carbohidratos complejos: avena, arroz integral, pasta, batata, quinoa.'),
('nutricion','subir',0.00,18.49,'Batidos caseros: leche, avena, banana, mantequilla de maní, proteína. 500+ kcal fáciles.'),
('nutricion','subir',0.00,18.49,'No te llenes con agua antes de comer. Bebe entre comidas, no durante.'),
('nutricion','subir',0.00,18.49,'Agrega aceite de oliva extra virgen a tus comidas. Calorías saludables extra.'),
('nutricion','subir',0.00,18.49,'Come antes de dormir: yogurt griego con frutos secos. Nutrientes mientras descansas.'),
('nutricion','subir',0.00,18.49,'Usa platos grandes. El tamaño visual ayuda a comer más.'),

-- Motivación para subir
INSERT INTO consejos (tipo, objetivo, imc_min, imc_max, mensaje) VALUES
('motivacion','subir',0.00,18.49,'Tu cuerpo necesita tiempo para construir músculo. La paciencia es tu mejor herramienta.'),
('motivacion','subir',0.00,18.49,'Ganar peso saludable es un maratón, no una carrera. Sé constante.'),
('motivacion','subir',0.00,18.49,'Cada comida es una oportunidad para nutrir tu cuerpo. No te saltes ninguna.'),
('motivacion','subir',0.00,18.49,'Los resultados llegarán. Confía en tu disciplina y en tu esfuerzo.'),
('motivacion','subir',0.00,18.49,'No compares tu progreso con otros. Cada cuerpo es único y responde diferente.'),

-- ============================================
-- CONSEJOS PARA MANTENER PESO
-- ============================================

-- Ejercicio para mantener (IMC normal 18.5-24.9)
INSERT INTO consejos (tipo, objetivo, imc_min, imc_max, mensaje) VALUES
('ejercicio','mantener',18.50,24.99,'Mantén una rutina balanceada: 3 días cardio, 2 días fuerza. Equilibrio es clave.'),
('ejercicio','mantener',18.50,24.99,'Camina 10,000 pasos diarios. Usa un contador de pasos para monitorearte.'),
('ejercicio','mantener',18.50,24.99,'Practica tu deporte favorito 2 veces por semana. El ejercicio debe ser disfrutable.'),
('ejercicio','mantener',18.50,24.99,'Estira 10 minutos al día. Mantiene flexibilidad y previene lesiones.'),
('ejercicio','mantener',18.50,24.99,'Varía tus rutinas. El cuerpo se adapta, sorpréndelo con nuevos ejercicios.'),
('ejercicio','mantener',18.50,24.99,'Haz ejercicio social: clases grupales, deportes en equipo. Más motivante.'),

-- Nutrición para mantener
INSERT INTO consejos (tipo, objetivo, imc_min, imc_max, mensaje) VALUES
('nutricion','mantener',18.50,24.99,'Sigue la regla 80/20: 80% alimentación saludable, 20% disfrutes ocasionales.'),
('nutricion','mantener',18.50,24.99,'Come consciente. Disfruta cada bocado, identifica señales de saciedad.'),
('nutricion','mantener',18.50,24.99,'Mantén un balance: proteínas, carbohidratos y grasas saludables en cada comida.'),
('nutricion','mantener',18.50,24.99,'Cocina en casa la mayor parte del tiempo. Tienes control total de ingredientes.'),
('nutricion','mantener',18.50,24.99,'Hidrátate bien: 2 litros de agua al día. Tu cuerpo lo necesita.'),
('nutricion','mantener',18.50,24.99,'Come frutas y verduras de todos los colores. Cada color aporta nutrientes diferentes.'),
('nutricion','mantener',18.50,24.99,'Planifica pero sé flexible. La vida es para disfrutarse con balance.'),

-- Motivación para mantener
INSERT INTO consejos (tipo, objetivo, imc_min, imc_max, mensaje) VALUES
('motivacion','mantener',18.50,24.99,'¡Excelente! Estás en tu peso ideal. Sigue con tus buenos hábitos.'),
('motivacion','mantener',18.50,24.99,'La consistencia te trajo aquí. Sigue disfrutando tu estilo de vida saludable.'),
('motivacion','mantener',18.50,24.99,'Mantener es tan importante como alcanzar. Estás en el camino correcto.'),
('motivacion','mantener',18.50,24.99,'Tu disciplina es inspiradora. Recuerda que la salud es un estilo de vida, no una meta temporal.'),
('motivacion','mantener',18.50,24.99,'Escucha a tu cuerpo. Conoces lo que necesitas, confía en tus decisiones.');

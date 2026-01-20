<?php

class FoodTranslator {
    
    private static $translations = [
        // Carnes y Proteínas
        'Chicken' => 'Pollo',
        'chicken' => 'pollo',
        'Beef' => 'Carne de res',
        'beef' => 'carne de res',
        'Pork' => 'Cerdo',
        'pork' => 'cerdo',
        'Turkey' => 'Pavo',
        'turkey' => 'pavo',
        'Fish' => 'Pescado',
        'fish' => 'pescado',
        'Salmon' => 'Salmón',
        'salmon' => 'salmón',
        'Tuna' => 'Atún',
        'tuna' => 'atún',
        'Ham' => 'Jamón',
        'ham' => 'jamón',
        'Sausage' => 'Salchicha',
        'sausage' => 'salchicha',
        'Egg' => 'Huevo',
        'egg' => 'huevo',
        
        // Lácteos
        'Milk' => 'Leche',
        'milk' => 'leche',
        'Cheese' => 'Queso',
        'cheese' => 'queso',
        'Yogurt' => 'Yogur',
        'yogurt' => 'yogur',
        'Butter' => 'Mantequilla',
        'butter' => 'mantequilla',
        
        // Vegetales
        'Tomato' => 'Tomate',
        'tomato' => 'tomate',
        'Tomatoes' => 'Tomates',
        'tomatoes' => 'tomates',
        'Carrot' => 'Zanahoria',
        'carrot' => 'zanahoria',
        'Broccoli' => 'Brócoli',
        'broccoli' => 'brócoli',
        'Onion' => 'Cebolla',
        'onion' => 'cebolla',
        'Garlic' => 'Ajo',
        'garlic' => 'ajo',
        'Potato' => 'Papa',
        'potato' => 'papa',
        'Potatoes' => 'Papas',
        'potatoes' => 'papas',
        'Lettuce' => 'Lechuga',
        'lettuce' => 'lechuga',
        'Spinach' => 'Espinaca',
        'spinach' => 'espinaca',
        'Kale' => 'Col rizada',
        'kale' => 'col rizada',
        'Cucumber' => 'Pepino',
        'cucumber' => 'pepino',
        'Bell pepper' => 'Pimiento',
        'bell pepper' => 'pimiento',
        
        // Frutas
        'Apple' => 'Manzana',
        'apple' => 'manzana',
        'Banana' => 'Plátano',
        'banana' => 'plátano',
        'Orange' => 'Naranja',
        'orange' => 'naranja',
        'Grape' => 'Uva',
        'grape' => 'uva',
        'Grapes' => 'Uvas',
        'grapes' => 'uvas',
        'Strawberr' => 'Fresa',
        'strawberr' => 'fresa',
        'Melon' => 'Melón',
        'melon' => 'melón',
        'Watermelon' => 'Sandía',
        'watermelon' => 'sandía',
        'Peach' => 'Durazno',
        'peach' => 'durazno',
        'Pear' => 'Pera',
        'pear' => 'pera',
        'Kiwi' => 'Kiwi',
        'kiwi' => 'kiwi',
        'Cantaloupe' => 'Melón',
        'cantaloupe' => 'melón',
        'Grapefruit' => 'Toronja',
        'grapefruit' => 'toronja',
        
        // Granos y Cereales
        'Rice' => 'Arroz',
        'rice' => 'arroz',
        'Bread' => 'Pan',
        'bread' => 'pan',
        'Pasta' => 'Pasta',
        'pasta' => 'pasta',
        'Flour' => 'Harina',
        'flour' => 'harina',
        'Oat' => 'Avena',
        'oat' => 'avena',
        'Wheat' => 'Trigo',
        'wheat' => 'trigo',
        'Corn' => 'Maíz',
        'corn' => 'maíz',
        
        // Legumbres
        'Bean' => 'Frijol',
        'bean' => 'frijol',
        'Beans' => 'Frijoles',
        'beans' => 'frijoles',
        'Lentil' => 'Lenteja',
        'lentil' => 'lenteja',
        'Chickpea' => 'Garbanzo',
        'chickpea' => 'garbanzo',
        'Hummus' => 'Hummus',
        'hummus' => 'hummus',
        
        // Nueces y Semillas
        'Almond' => 'Almendra',
        'almond' => 'almendra',
        'Almonds' => 'Almendras',
        'almonds' => 'almendras',
        'Walnut' => 'Nuez',
        'walnut' => 'nuez',
        'Peanut' => 'Maní',
        'peanut' => 'maní',
        'Cashew' => 'Anacardo',
        'cashew' => 'anacardo',
        'Nut' => 'Fruto seco',
        'nut' => 'fruto seco',
        'Nuts' => 'Frutos secos',
        'nuts' => 'frutos secos',
        
        // Términos de cocción
        'raw' => 'crudo',
        'cooked' => 'cocido',
        'boiled' => 'hervido',
        'baked' => 'horneado',
        'grilled' => 'a la parrilla',
        'fried' => 'frito',
        'roasted' => 'asado',
        'steamed' => 'al vapor',
        'canned' => 'enlatado',
        'frozen' => 'congelado',
        'dried' => 'seco',
        'fresh' => 'fresco',
        
        // Otros términos
        'with' => 'con',
        'without' => 'sin',
        'added' => 'añadido',
        'reduced fat' => 'bajo en grasa',
        'lowfat' => 'bajo en grasa',
        'nonfat' => 'sin grasa',
        'whole' => 'entero',
        'sliced' => 'rebanado',
        'ground' => 'molido',
        'juice' => 'jugo',
        'oil' => 'aceite',
        'salt' => 'sal',
        'sugar' => 'azúcar',
        'Sugars' => 'Azúcares',
        'sugars' => 'azúcares',
    ];
    
    public static function translate($text) {
        if (empty($text)) return $text;
        
        $result = $text;
        
        // Reemplazar términos completos primero
        foreach (self::$translations as $en => $es) {
            $result = str_ireplace($en, $es, $result);
        }
        
        // Limpiar y formatear
        $result = self::cleanText($result);
        
        return $result;
    }
    
    private static function cleanText($text) {
        // Capitalizar primera letra
        $text = ucfirst(strtolower($text));
        
        // Remover términos técnicos innecesarios
        $removes = [
            ', commercial',
            'with added vitamin A and vitamin D',
            ', pre-cooked, unprepared',
            ', unprepared',
            'pre-packaged',
            'deli meat',
            '(96%fat free, water added)',
            ', pasteurized',
            'broilers or fryers',
            'meat only',
        ];
        
        foreach ($removes as $remove) {
            $text = str_ireplace($remove, '', $text);
        }
        
        // Limpiar espacios múltiples
        $text = preg_replace('/\s+/', ' ', $text);
        $text = trim($text);
        
        // Limpiar comas al final
        $text = rtrim($text, ',');
        
        return $text;
    }
}

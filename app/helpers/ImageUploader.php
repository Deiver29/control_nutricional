<?php

class ImageUploader {
    
    private static $uploadDir = 'assets/uploads/';
    private static $maxSize = 5242880; // 5MB
    private static $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
    private static $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
    
    /**
     * Sube una imagen a la carpeta especificada
     * @param array $file - Archivo de $_FILES
     * @param string $folder - Carpeta destino (profile, progress, meals)
     * @param string $prefix - Prefijo opcional para el nombre del archivo
     * @return array - ['success' => bool, 'filename' => string, 'error' => string]
     */
    public static function upload($file, $folder = 'profile', $prefix = '') {
        // Validar que el archivo existe
        if (!isset($file['tmp_name']) || empty($file['tmp_name'])) {
            return ['success' => false, 'error' => 'No se recibió ningún archivo'];
        }
        
        // Validar errores de carga
        if ($file['error'] !== UPLOAD_ERR_OK) {
            return ['success' => false, 'error' => self::getUploadErrorMessage($file['error'])];
        }
        
        // Validar tamaño
        if ($file['size'] > self::$maxSize) {
            return ['success' => false, 'error' => 'El archivo es demasiado grande. Máximo 5MB'];
        }
        
        // Validar tipo de archivo
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mimeType = finfo_file($finfo, $file['tmp_name']);
        finfo_close($finfo);
        
        if (!in_array($mimeType, self::$allowedTypes)) {
            return ['success' => false, 'error' => 'Tipo de archivo no permitido. Solo imágenes JPG, PNG, GIF, WEBP'];
        }
        
        // Validar extensión
        $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        if (!in_array($extension, self::$allowedExtensions)) {
            return ['success' => false, 'error' => 'Extensión no permitida'];
        }
        
        // Crear nombre único
        $filename = ($prefix ? $prefix . '_' : '') . uniqid() . '_' . time() . '.' . $extension;
        
        // Ruta completa
        $uploadPath = self::$uploadDir . $folder . '/';
        $fullPath = __DIR__ . '/../../public/' . $uploadPath . $filename;
        
        // Asegurar que el directorio existe
        if (!is_dir(dirname($fullPath))) {
            mkdir(dirname($fullPath), 0755, true);
        }
        
        // Mover archivo
        if (!move_uploaded_file($file['tmp_name'], $fullPath)) {
            return ['success' => false, 'error' => 'Error al guardar el archivo'];
        }
        
        // Retornar éxito con ruta relativa
        return [
            'success' => true,
            'filename' => $filename,
            'path' => $uploadPath . $filename
        ];
    }
    
    /**
     * Elimina una imagen
     * @param string $path - Ruta relativa de la imagen
     * @return bool
     */
    public static function delete($path) {
        if (empty($path)) {
            return false;
        }
        
        $fullPath = __DIR__ . '/../../public/' . $path;
        
        if (file_exists($fullPath)) {
            return unlink($fullPath);
        }
        
        return false;
    }
    
    /**
     * Redimensiona una imagen manteniendo proporción
     * @param string $sourcePath - Ruta de la imagen original
     * @param int $maxWidth - Ancho máximo
     * @param int $maxHeight - Alto máximo
     * @return bool
     */
    public static function resize($sourcePath, $maxWidth = 800, $maxHeight = 800) {
        $fullPath = __DIR__ . '/../../public/' . $sourcePath;
        
        if (!file_exists($fullPath)) {
            return false;
        }
        
        list($width, $height, $type) = getimagesize($fullPath);
        
        // Si ya es pequeña, no hacer nada
        if ($width <= $maxWidth && $height <= $maxHeight) {
            return true;
        }
        
        // Calcular nuevas dimensiones
        $ratio = min($maxWidth / $width, $maxHeight / $height);
        $newWidth = round($width * $ratio);
        $newHeight = round($height * $ratio);
        
        // Crear imagen según tipo
        switch ($type) {
            case IMAGETYPE_JPEG:
                $source = imagecreatefromjpeg($fullPath);
                break;
            case IMAGETYPE_PNG:
                $source = imagecreatefrompng($fullPath);
                break;
            case IMAGETYPE_GIF:
                $source = imagecreatefromgif($fullPath);
                break;
            case IMAGETYPE_WEBP:
                $source = imagecreatefromwebp($fullPath);
                break;
            default:
                return false;
        }
        
        // Crear imagen redimensionada
        $destination = imagecreatetruecolor($newWidth, $newHeight);
        
        // Preservar transparencia para PNG y GIF
        if ($type == IMAGETYPE_PNG || $type == IMAGETYPE_GIF) {
            imagealphablending($destination, false);
            imagesavealpha($destination, true);
            $transparent = imagecolorallocatealpha($destination, 255, 255, 255, 127);
            imagefilledrectangle($destination, 0, 0, $newWidth, $newHeight, $transparent);
        }
        
        // Redimensionar
        imagecopyresampled($destination, $source, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
        
        // Guardar según tipo
        switch ($type) {
            case IMAGETYPE_JPEG:
                imagejpeg($destination, $fullPath, 85);
                break;
            case IMAGETYPE_PNG:
                imagepng($destination, $fullPath, 8);
                break;
            case IMAGETYPE_GIF:
                imagegif($destination, $fullPath);
                break;
            case IMAGETYPE_WEBP:
                imagewebp($destination, $fullPath, 85);
                break;
        }
        
        // Liberar memoria
        imagedestroy($source);
        imagedestroy($destination);
        
        return true;
    }
    
    /**
     * Obtiene mensaje de error según código
     * @param int $code
     * @return string
     */
    private static function getUploadErrorMessage($code) {
        switch ($code) {
            case UPLOAD_ERR_INI_SIZE:
            case UPLOAD_ERR_FORM_SIZE:
                return 'El archivo es demasiado grande';
            case UPLOAD_ERR_PARTIAL:
                return 'El archivo se subió parcialmente';
            case UPLOAD_ERR_NO_FILE:
                return 'No se subió ningún archivo';
            case UPLOAD_ERR_NO_TMP_DIR:
                return 'Falta la carpeta temporal';
            case UPLOAD_ERR_CANT_WRITE:
                return 'Error al escribir el archivo';
            case UPLOAD_ERR_EXTENSION:
                return 'Una extensión de PHP detuvo la carga';
            default:
                return 'Error desconocido al subir el archivo';
        }
    }
}

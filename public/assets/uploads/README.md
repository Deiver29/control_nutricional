# 📁 Carpeta de Uploads

Esta carpeta almacena las imágenes subidas por los usuarios de la aplicación.

## 📂 Estructura

```
uploads/
├── profile/      # Fotos de perfil de usuarios
├── progress/     # Fotos de progreso físico
└── meals/        # Fotos de comidas (para futuras funcionalidades)
```

## 🔒 Seguridad

- ✅ Solo se permiten archivos de imagen (JPG, PNG, GIF, WEBP)
- ✅ Ejecución de PHP deshabilitada en esta carpeta
- ✅ Tamaño máximo: 5MB por archivo
- ✅ Archivos index.php previenen listado de directorios
- ✅ .htaccess bloquea tipos de archivo peligrosos

## 💻 Uso

Para subir imágenes, usa la clase `ImageUploader`:

```php
require_once 'app/helpers/ImageUploader.php';

// Subir foto de perfil
$result = ImageUploader::upload($_FILES['photo'], 'profile', 'user_' . $userId);

if ($result['success']) {
    echo "Imagen subida: " . $result['path'];
    // Guardar en base de datos: $result['path']
} else {
    echo "Error: " . $result['error'];
}
```

## 🖼️ Funcionalidades

- **upload($file, $folder, $prefix)** - Sube una imagen
- **delete($path)** - Elimina una imagen
- **resize($path, $maxWidth, $maxHeight)** - Redimensiona automáticamente

## ⚠️ Importante

**No eliminar esta carpeta**. Es necesaria para el funcionamiento de la aplicación.

Los archivos subidos NO deben incluirse en el control de versiones (git).

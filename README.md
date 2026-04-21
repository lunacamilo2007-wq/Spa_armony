# SPA Armonía - Sistema de Gestión 🌿

Un sistema de gestión integral, moderno y responsivo para el SPA Armonía. Construido para agilizar la administración de clientes, masajistas, servicios y control de citas exclusivas de manera elegante.

## 🛠️ Tecnologías Utilizadas

*   **Backend:** Laravel 12.x / PHP 8.2+
*   **Frontend:** Alpine.js, Tailwind CSS v4, Blade Templates, Vite
*   **Base de Datos:** SQLite (Tests y local por defecto para agilidad) / MySQL (Producción)
*   **Autenticación y Seguridad (NUEVO):** Guard personalizado de Laravel, encriptación de contraseñas con Hash y protección activa de sesión mediante JS (Beacon API).

---

## 🌟 Características y Módulos del Sistema

*   **🔐 Seguridad y Acceso (NUEVO):** El sistema administrativo está totalmente protegido. Todas las rutas requieren inicio de sesión previo.
    *   **Credenciales por defecto:** Usuario: `admin1` | Contraseña: `admin123`
    *   **Auto-cierre de sesión:** Al intentar cerrar la pestaña o el navegador, el sistema lanza una advertencia. Si el usuario confirma la salida, la sesión se invalida y cierra automáticamente en el servidor para evitar accesos no autorizados posteriores.
*   **📊 Dashboard Administrativo:** Panel principal con métricas en tiempo real (estado de citas de hoy, pendientes, totales de clientes/masajistas) y un resumen rápido de la agenda del día.
*   **📅 Gestión de Citas:** Control integral de la agenda. Permite crear citas, seleccionar el masajista, servicio y cliente, y manejar el ciclo de vida de la cita (Pendiente -> Confirmada -> Finalizada o Cancelada).
*   **👥 Directorio de Clientes y Personal:** Módulos CRUD dedicados para gestionar los perfiles de los clientes que asisten al SPA y la plantilla de masajistas.
*   **💆 Catálogo de Servicios:** Administración de los tipos de tratamientos y masajes ofrecidos.

---

## 🚀 Requisitos Previos Generales

Para poder ejecutar este proyecto en tu computadora, debes tener instaladas las siguientes herramientas:

1.  **[PHP (>= 8.2)](https://windows.php.net/download/)**: Es el lenguaje principal del servidor.
2.  **[Composer](https://getcomposer.org/download/)**: El gestor de dependencias de PHP.
3.  **[Node.js (LTS)](https://nodejs.org/)**: Requerido para instalar dependencias de frontend y empaquetar Tailwind CSS y Alpine.js con Vite.
4.  **[Git](https://git-scm.com/)**: Para clonar el repositorio.

---

## ⚙️ Instrucciones de Instalación Local (Paso a Paso)

Si te acaban de compartir este proyecto, sigue estos pasos exactamente en este orden desde tu terminal (PowerShell, CMD o bash):

### 1. Clonar e Instalar código
```bash
# Entra a la carpeta del proyecto que clonaste 
cd Spa_armony

# Instala todas las librerías del backend (Laravel)
composer install

# Instala las herramientas de diseño y frontend (AlpineJS/Tailwind CSS)
npm install
```

### 2. Configurar Entorno
Deberás crear tu propio archivo oculto de configuración local copiando el ejemplo del proyecto:
```bash
# Si usas Windows CMD/PowerShell:
copy .env.example .env

# (Si usas Mac/Linux: cp .env.example .env)
```

Genera la llave de encriptación de tu proyecto:
```bash
php artisan key:generate
```

### 3. Base de Datos (Primer encendido)
Por ahora está pre-configurado para que tu base de datos y tus "sesiones" funcionen sin problemas a nivel de archivos temporales en local. Solo debes asegurar que las tablas se creen:

```bash
php artisan migrate:fresh

# Sembrar la base de datos con el usuario administrador por defecto
php artisan db:seed --class=AdminSeeder
```


### 4. Compilar Diseño y Encender Servidor
Finalmente, debes decirle a Node que consolide los estilos modernos en `app.css` y luego encender Laravel:

```bash
# (Comando crucial para que el SPA se vea increíble y cargue Tailwind v4)
npm run build 

# Levanta el servidor localmente
php artisan serve
```

---

## 🧪 Validar Código (Opcional)
Si eres desarrollador y deseas validar que todas las lógicas creadas se mantengan intactas, ejecuta la suite completa de pruebas automáticas:
```bash
php artisan test
```

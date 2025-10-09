# 🔐 Laravel SSO Backend – Versión 1

API Backend desarrollada en **Laravel 11** que implementa un sistema **Single Sign-On (SSO)** con autenticación basada en **JWT**, validación de token, envío de notificaciones y acceso a procesos restringidos.

---

## 🚀 Características principales

- ✅ Autenticación mediante **documento y contraseña**
- ✅ Generación y validación de **tokens JWT**
- ✅ Envío de **notificaciones por canal** (Email, SMS, Telegram)
- ✅ **Middleware de autenticación** para rutas protegidas
- ✅ Respuestas **JSON estandarizadas**
- ✅ Arquitectura limpia con capas:
  - **Controllers**
  - **Services (Dominio)**
  - **Infrastructure (Infraestructura)**
  - **Support / Traits (utilitarios y constantes)**

---

## 🧱 Estructura de carpetas relevante

app/
├── Domain/
│ └── Services/
│ └── AuthService.php
├── Http/
│ ├── Controllers/
│ │ └── Api/V1/
│ │ ├── AuthController.php
│ │ ├── NotificationController.php
│ │ └── ProcessController.php
│ ├── Requests/
│ │ └── LoginRequest.php
│ └── Middleware/
├── Infrastructure/
│ ├── Notifications/
│ │ ├── EmailNotification.php
│ │ ├── SmsNotification.php
│ │ └── TelegramNotification.php
│ └── Persistence/
│ └── Models/
│ └── User.php
├── Support/
│ └── Constant.php
└── Traits/
└── ApiResponse.php


---

## ⚙️ Instalación del proyecto

### 1️⃣ Clonar el repositorio
```bash
git clone https://github.com/<tu_usuario>/laravel-sso-backend.git
cd laravel-sso-backend

2️⃣ Instalar dependencias

composer install

3️⃣ Instalar y configurar JWT Auth

Ejecuta los siguientes comandos para habilitar la autenticación basada en tokens JWT:

composer require tymon/jwt-auth
php artisan vendor:publish --provider="Tymon\JWTAuth\Providers\LaravelServiceProvider"
php artisan jwt:secret


4️⃣ Configurar el entorno

Copia el archivo .env.example o crea uno nuevo .env con tus credenciales.
Ejemplo:

APP_NAME=SSO_Backend
APP_ENV=local
APP_KEY=base64:xxxxx
APP_DEBUG=true
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=sso_db
DB_USERNAME=root
DB_PASSWORD=

MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=tu_cuenta@gmail.com
MAIL_PASSWORD=tu_contraseña_de_aplicacion
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=tu_cuenta@gmail.com
MAIL_FROM_NAME="SSO Backend"

JWT_SECRET=joHNoKO5DO7gV5ssNDIYr6t2t4t91o5tlfXfARH8UlZSTyfKmkKPHLCyRAj6KfHr
JWT_TTL=120

5️⃣ Migrar la base de datos

php artisan migrate

5️⃣ Ejecutar el servidor local
php artisan serve

6️⃣ Limpiar y optimizar cachés

php artisan optimize:clear

7️⃣ Iniciar el servidor

php artisan serve

🧩 Endpoints disponibles (V1)

| Método | Endpoint                     | Descripción                                           | Protección             |
| ------ | ---------------------------- | ----------------------------------------------------- | ---------------------- |
| POST   | `/api/v1/auth/login`         | Autentica al usuario por documento y genera token JWT | Pública                |
| POST   | `/api/v1/auth/validate`      | Valida si un token JWT es válido                      | Pública                |
| POST   | `/api/v1/notifications/send` | Envía notificación por email, sms o telegram          | Pública (por ahora)    |
| GET    | `/api/v1/process/restricted` | Endpoint protegido — requiere token válido            | Protegido (`auth:api`) |


📦 Estandarización de respuestas API

{
  "success": true,
  "message": "Inicio de sesión exitoso",
  "data": {
    "access_token": "...",
    "token_type": "bearer",
    "expires_in": "120"
  }
}

Errores también siguen el mismo formato:

{
  "success": false,
  "message": "Errores de validación",
  "data": {
    "document": ["El campo documento es obligatorio."]
  }
}



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
    │   └── Services/
    │       └── AuthService.php
    ├── Http/
    │   ├── Controllers/
    │   │   └── Api/
    │   │       └── V1/
    │   │           ├── AuthController.php
    │   │           ├── NotificationController.php
    │   │           └── ProcessController.php
    │   ├── Requests/
    │   │   └── LoginRequest.php
    │   └── Middleware/
    ├── Infrastructure/
    │   ├── Notifications/
    │   │   ├── EmailNotification.php
    │   │   ├── SmsNotification.php
    │   │   └── TelegramNotification.php
    │   └── Persistence/
    │       └── Models/
    │           └── User.php
    ├── Support/
    │   └── Constant.php
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

### 🧩 Endpoints disponibles

    | Versión | Método | Endpoint                | Descripción                      | Entrada esperada                                     |
    | ------- | ------ | ----------------------- | -------------------------------- | ---------------------------------------------------- |
    | v1      | POST   | `/api/v1/auth/login`    | Login por documento + contraseña | `{ "document": "123", "password": "123456" }`        |
    | v1      | POST   | `/api/v1/auth/validate` | Valida token JWT                 | `{ "token": "<jwt>" }`                               |
    | v2      | POST   | `/api/v2/auth/login`    | Login por correo + contraseña    | `{ "email": "user@mail.com", "password": "123456" }` |
    | v3      | POST   | `/api/v3/auth/login`    | Login mediante código OTP        | `{ "codigoOTP": "458760" }`                          |
    
    🔸 Procesos restringidos
    
    | Versión | Método | Endpoint                     | Descripción            | Autenticación    |
    | ------- | ------ | ---------------------------- | ---------------------- | ---------------- |
    | v1      | GET    | `/api/v1/process/restricted` | Endpoint protegido JWT | ✅ Requiere token |
    | v2      | GET    | `/api/v2/process/restricted` | Endpoint protegido JWT | ✅ Requiere token |
    | v3      | GET    | `/api/v3/process/restricted` | Endpoint protegido JWT | ✅ Requiere token |
    
    
    🔸 Notificaciones
    
    | Método | Endpoint                     | Descripción                             | Entrada                                                                                  |
    | ------ | ---------------------------- | --------------------------------------- | ---------------------------------------------------------------------------------------- |
    | POST   | `/api/v1/notifications/send` | Envía mensaje por email, SMS o Telegram | `{ "canal": "email", "destino": "user@mail.com", "mensaje": "Tu código OTP es 458760" }` |

---

### 📦 Estandarización de respuestas API

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

---

### 📡 Endpoints disponibles y ejemplos de consumo

    Los endpoints están versionados (/api/v1, /api/v2, /api/v3) para reflejar la evolución del sistema SSO y garantizar la retrocompatibilidad entre clientes.
    
 ###  🔑 **Autenticación V1 – /api/v1/auth/login**
        
                Método: POST
                Descripción: Autentica al usuario usando documento y contraseña, generando un token JWT.
                
                Body (JSON):
                {
                  "document": "1087956872",
                  "password": "123456"
                }
                
                Respuesta exitosa:
                
                {
                  "success": true,
                  "message": "Inicio de sesión exitoso (v1).",
                  "data": {
                    "access_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9...",
                    "refresh_token": "ZndUNFJVSVdxS3dXUTRSRGp3NDVvNXRTV2NGT0oz"
                  }
                }
    
### ✉️ **Notificaciones (v1) – /api/v1/notifications/send**
    
    Método: POST
    Descripción: Envía mensajes por correo electrónico, SMS o Telegram.
    En este caso, se usa para enviar el código OTP de la autenticación v3.
    
    Body (JSON):
    
    {
      "canal": "email",
      "destino": "pedro.toro@ucp.edu.co"
    }
    
    Respuesta exitosa:
    
    {
      "success": true,
      "message": "Notificación enviada correctamente.",
      "data": {
        "sent": true,
        "destino": "pedro.toro@ucp.edu.co",
        "mensaje": "Tu código OTP es: 406233. Este código es válido por 2 minutos. No lo compartas con nadie."
      }
    }
    
### 🔒 **Proceso restringido V1 – /api/v1/process/restricted**
    
    Método: GET
    Protección: Requiere token JWT válido en el header:
    
    Authorization: Bearer <token>
    
    
    Respuesta exitosa:
    
    {
      "success": true,
      "message": "Operación exitosa.",
      "data": {
        "message": "Acceso exitoso a proceso restringido versión v1."
      }
    }
    
### 🔑 **Autenticación V2 – /api/v2/auth/login**
    
    Método: POST
    Descripción: Autentica al usuario usando correo electrónico y contraseña.
    
    Body (JSON):
    
    {
      "email": "pedro.toro@ucp.edu.co",
      "password": "123456"
    }
    
    
    Respuesta exitosa:
    
    {
      "success": true,
      "message": "Inicio de sesión exitoso (v2).",
      "data": {
        "access_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9...",
        "refresh_token": "RVhTMEdHYmRDY1h3WmpRS0xRa1FJZzhiVWRUSFRB"
      }
    }
    
### 🔒 **Proceso restringido V2 – /api/v2/process/restricted**
    
    Método: GET
    Protección: JWT requerido.
    
    Respuesta exitosa:
    
    {
      "success": true,
      "message": "Operación exitosa.",
      "data": {
        "message": "Acceso exitoso a proceso restringido versión v2.",
        "meta": {
          "version": "v2",
          "timestamp": "2025-10-22 14:03:07",
          "environment": "local"
        }
      }
    }
    
### 🔑 **Autenticación V3 (OTP) – /api/v3/auth/login**
    
    Método: POST
    Descripción: Autentica al usuario únicamente con un código OTP previamente enviado al correo o canal configurado mediante /api/v1/notifications/send.
    
    Body (JSON):
    
    {
      "codigoOTP": "635395"
    }
    
    
       Respuesta exitosa:
    
    {
      "success": true,
      "message": "Inicio de sesión exitoso (v3).",
      "data": {
        "access_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9...",
        "token_type": "bearer",
        "expires_in": "120"
      }
    }
    
 ### 🔒 **Proceso restringido V3**
    
    Método: GET
    Protección: JWT requerido.
    
    Respuesta exitosa:
    
    {
      "success": true,
      "message": "Operación exitosa.",
      "data": {
        "message": "Acceso exitoso a proceso restringido versión v3."
      }
    }
---




# 1\. Microservicio Autenticación (PRY\_AUTENTICACION\_MICROSERVICIO)

> **Microservicio de Autenticación (Laravel)** — Gestión de usuarios, perfiles y emisión de tokens de seguridad (Sanctum).

### 🎓 Estudiantes

  * **Betty Rodriguez**
  * **Victor Villamarin**

-----

## 🛠️ Requisitos Previos

Asegúrate de tener instalado lo siguiente:

  - **PHP 8.2** o superior
  - **Composer**
  - **Node.js** y **npm**
  - **MySQL**


-----

## 🚀 Instalación y Configuración

Sigue estos pasos para desplegar el proyecto correctamente:

### 1\. Clonar el Repositorio

```bash
git clone https://github.com/sebasrob56-star/MicroservicioAut_ExmPr-ctico_1P.git
cd MicroservicioAut_ExmPr-ctico_1P
```

### 2\. Instalar Dependencias

Instala las librerías necesarias tanto de PHP como de Node.js:

```bash
composer install
npm install
```

### 3\. Configurar el Entorno (.env)

Copia el archivo de ejemplo y genera la llave de encriptación:

```bash
cp .env.example .env
php artisan key:generate
```

### 4\. Base de Datos

Crea una base de datos vacía llamada `db_users` en tu gestor MySQL y actualiza tu archivo `.env`:

```ini
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=db_users
DB_USERNAME=root
DB_PASSWORD=
```

### 5\. Ejecutar Migraciones

Crea las tablas en la base de datos:

```bash
php artisan migrate
```

### 6\. Levantar el Servidor

Inicia el servidor en el **puerto 8001** (para no chocar con el microservicio de Posts):

```bash
php artisan serve --host=127.0.0.1 --port=8001
```

-----

## 🔐 Rutas API y Seguridad

El sistema utiliza prefijos específicos para las rutas de autenticación.

**Prefijo General:** `/api/login`

### 🌍 Rutas Públicas

| Método | Endpoint | Descripción |
| :--- | :--- | :--- |
| `POST` | `/api/login/register` | Registro de nuevos usuarios con perfil. |
| `POST` | `/api/login/login` | Inicio de sesión y generación de token. |

### 🔒 Rutas Protegidas (Requieren Token)

| Método | Endpoint | Descripción |
| :--- | :--- | :--- |
| `POST` | `/api/login/logout` | Cierre de sesión y revocación del token. |
| `GET` | `/api/login/me` | Información completa del usuario autenticado. |
| `GET` | `/api/login/user` | Datos básicos (id, nombre, email, rol). |

### 👤 Perfiles de Usuario (Roles)

El sistema implementa permisos basados en roles:

  * **Administrador:** Acceso completo a todos los recursos.
  * **Usuario:** Usuario estándar con permisos limitados (lectura).

-----

## 🧪 Postman

Se incluye una colección completa para pruebas en la carpeta `postman/` en el eproyecto https://github.com/saoricoder/MicroservicioPos_ExmPractico_1P.git.

**Características de la colección:**

  - Endpoints preconfigurados para Login, Registro y Logout.
  - Scripts automáticos para capturar el token tras el login.
  - Documentación de parámetros requeridos.

-----

## 🛠️ Comandos Útiles

Si realizas cambios en la configuración o rutas y no se reflejan, ejecuta:

```bash
# Limpiar caché de configuración y rutas
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

-----

**Estado:** 🟢 El microservicio está listo para validar usuarios mediante tokens de Laravel Sanctum.
# BACK-SWAPI

Backend para consumir y exponer datos de la API de Star Wars (SWAPI) como servicio.

![PHP / Laravel](https://img.shields.io/badge/php-8.*-blue) ![Laravel](https://img.shields.io/badge/laravel-framework-red) ![License MIT](https://img.shields.io/badge/license-MIT-green)

---

## 🔍 Índice

1. [Descripción](#descripción)
2. [Tecnologías usadas](#tecnologías-usadas)
3. [Funcionalidades principales](#funcionalidades-principales)
4. [Instalación](#instalación)
5. [Configuración](#configuración)
6. [Uso / Endpoints](#uso--endpoints)
7. [Pruebas](#pruebas)
8. [Contribuir](#contribuir)
9. [Licencia](#licencia)
10. [Contacto](#contacto)

---

## 📝 Descripción

Este proyecto es un backend en Laravel que actúa como middleware para consumir datos de la API pública **SWAPI** (Star Wars API), procesarlos o filtrarlos según lógica propia, y exponerlos mediante endpoints personalizados.

El objetivo es tener un punto centralizado para manejar caché, control de errores, transformaciones específicas o reglas de negocio, y desacoplar el cliente (frontend, app, etc.) de depender directamente de SWAPI.

---

## 🧰 Tecnologías usadas

* PHP 8.x
* Laravel 
* Composer
* PHPUnit (para testing)
* Cliente HTTP de Laravel (o Guzzle)


---

## 🚀 Funcionalidades principales

* Consumir recursos de la API SWAPI (personajes, planetas, naves, etc.).
* Exponer endpoints REST personalizados.
* Soporte de filtros, paginación y transformaciones de datos.
* Manejo de caché para optimizar consultas a SWAPI.
* Tests automatizados para validar el comportamiento.

---

## 📥 Instalación

```bash
# Clona el repositorio
git clone https://github.com/JoseMartinez98/BACK-SWAPI.git
cd BACK-SWAPI

# Instala dependencias
composer install

# Copia el archivo de entorno
cp .env.example .env

# Genera la clave de la aplicación
php artisan key:generate

# (Opcional) Migraciones de base de datos
php artisan migrate
```

---

## ⚙️ Configuración

En el archivo `.env` deberías definir como mínimo:

```dotenv
APP_NAME="BACK-SWAPI"
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://localhost

SWAPI_BASE_URL=https://swapi.dev/api
SWAPI_TIMEOUT=10

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=tu_db
DB_USERNAME=usuario
DB_PASSWORD=contraseña
```

---

## 📡 Uso / Endpoints

Algunos ejemplos de endpoints expuestos (ajusta según tu `routes/api.php`):

| Método | Ruta                  | Descripción              |
| ------ | --------------------- | ------------------------ |
| GET    | `/api/people`         | Lista de personajes      |
| GET    | `/api/people/{id}`    | Detalles de un personaje |
| GET    | `/api/planets`        | Lista de planetas        |
| GET    | `/api/starships`      | Lista de naves           |
| GET    | `/api/starships/{id}` | Detalles de una nave     |

**Ejemplo de uso:**

```bash
curl http://localhost/api/people/1
```

Respuesta esperada:

```json
{
  "id": 1,
  "name": "Luke Skywalker",
  "height": "172",
  "mass": "77",
  "hair_color": "blond",
  "skin_color": "fair",
  ...
}
```

---

## 🧪 Pruebas

Ejecutar los tests:

```bash
php artisan test
```

---



## 📄 Licencia

Este proyecto está bajo la licencia **MIT**.
Consulta el archivo `LICENSE` para más detalles.

---

## 📬 Contacto

* Autor: José Martínez
* GitHub: [@JoseMartinez98](https://github.com/JoseMartinez98)
* Email: [josesw98@gamil.com](mailto:tuemail@ejemplo.com)


---

## 🏷️ Estado del proyecto

Actualmente en desarrollo.
Próximas mejoras planificadas:

* Autenticación / control de acceso.
* Documentación con Swagger / OpenAPI.
* Soporte para más recursos de SWAPI.
* Mejoras en caché e infraestructura.

# proyectoDAW — Taller de Reparación

Proyecto Integrador · Diseño de Base de Datos
Facultad de Matemáticas · UADY

## Integrantes
- Angel Zared Fuentes López
- Diego Isaiah Lizarraga Ramírez
- Henry Javier Llama Dzib

## Docente
Erika Rossana Llanes Castro

## Stack
- PHP 8.2 + Apache (XAMPP o Docker)
- MySQL 8 / MariaDB (XAMPP)
- PDO con prepared statements
- Sesiones PHP nativas + BCrypt

## Estructura
- `config/` → configuración y arranque de sesión
- `src/` → `Database`, `Auth`, modelos y DAOs
- `includes/` → header y footer compartidos
- `public/` → páginas accesibles (DocumentRoot en Docker)
- `sql/` → scripts SQL (estructura, seed, usuarios)
- `scripts/` → utilidades (generar hashes)

## Uso local con XAMPP
1. Inicia **Apache** y **MySQL** desde el panel de XAMPP.
2. Copia la carpeta `proyectoDAW/` dentro de `C:\xampp\htdocs\`.
3. Abre <http://localhost/phpmyadmin>, pestaña **Import**:
   - `sql/01_creacion_estructura.sql`
   - `sql/02_datos_prueba.sql`
   - `sql/03_usuarios.sql`
4. Abre <http://localhost/proyectoDAW/public/login.php>
5. Login: **admin** / **password**

## Uso local con Docker
```bash
docker compose up -d --build
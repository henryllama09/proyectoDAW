USE taller;

CREATE TABLE IF NOT EXISTS USUARIO (
    id_usuario      INT AUTO_INCREMENT PRIMARY KEY,
    username        VARCHAR(50)  NOT NULL UNIQUE,
    password_hash   VARCHAR(100) NOT NULL,
    nombre_completo VARCHAR(150) NOT NULL,
    rol             VARCHAR(20)  NOT NULL DEFAULT 'TECNICO',
    activo          TINYINT(1)   NOT NULL DEFAULT 1,
    fecha_creacion  TIMESTAMP    DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT chk_rol CHECK (rol IN ('ADMIN','TECNICO','RECEPCION'))
);

-- Contraseña por defecto: "password"  (hash BCrypt)
-- Para cambiar la contraseña: usa scripts/generar_hash.php y actualiza aquí.
INSERT INTO USUARIO (username, password_hash, nombre_completo, rol) VALUES
('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
          'Administrador del Taller', 'ADMIN')
ON DUPLICATE KEY UPDATE nombre_completo = VALUES(nombre_completo);
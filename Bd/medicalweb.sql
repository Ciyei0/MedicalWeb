-- Crear la Base de Datos si no existe
CREATE DATABASE IF NOT EXISTS medicalweb;
USE medicalweb;

-- Tabla de Permisos
CREATE TABLE IF NOT EXISTS permiso (
    id INT AUTO_INCREMENT PRIMARY KEY,
    permiso VARCHAR(50) NOT NULL UNIQUE
);

-- Tabla de Usuarios (Solo Médicos y Administración)
CREATE TABLE IF NOT EXISTS Usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL,
    apellido VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    nombre_usuario VARCHAR(50) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    cedula VARCHAR(20) NULL,
    telefono VARCHAR(20) NULL,
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    direccion TEXT NULL
);

-- Verificar y agregar columnas faltantes en la tabla Usuarios
ALTER TABLE Usuarios
    ADD COLUMN IF NOT EXISTS password_hash VARCHAR(255) NOT NULL AFTER nombre_usuario,
    ADD COLUMN IF NOT EXISTS cedula VARCHAR(20) NULL AFTER password_hash,
    ADD COLUMN IF NOT EXISTS telefono VARCHAR(20) NULL AFTER cedula,
    ADD COLUMN IF NOT EXISTS fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP AFTER telefono,
    ADD COLUMN IF NOT EXISTS direccion TEXT NULL AFTER fecha_registro;

-- Relación entre Usuarios y Permisos (Muchos a Muchos)
CREATE TABLE IF NOT EXISTS usuario_permiso (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT NOT NULL,
    id_permiso INT NOT NULL,
    UNIQUE (id_usuario, id_permiso),
    FOREIGN KEY (id_usuario) REFERENCES Usuarios(id) ON DELETE CASCADE,
    FOREIGN KEY (id_permiso) REFERENCES permiso(id) ON DELETE CASCADE
);

-- Tabla de Especialidades Médicas
CREATE TABLE IF NOT EXISTS Especialidades (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    descripcion TEXT NULL
);

-- Tabla de Médicos (Usuarios con especialidad)
CREATE TABLE IF NOT EXISTS Medicos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT NOT NULL,
    id_especialidad INT NOT NULL,
    experiencia TEXT NULL,
    FOREIGN KEY (id_usuario) REFERENCES Usuarios(id) ON DELETE CASCADE,
    FOREIGN KEY (id_especialidad) REFERENCES Especialidades(id) ON DELETE CASCADE
);

-- Tabla de Pacientes (Independiente de Usuarios)
CREATE TABLE IF NOT EXISTS Pacientes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL,
    apellido VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    telefono VARCHAR(20) NULL,
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Verificar y agregar columna 'cedula' en la tabla Pacientes
ALTER TABLE Pacientes
    ADD COLUMN IF NOT EXISTS cedula VARCHAR(20) NULL UNIQUE AFTER email;

-- Tabla de Citas (Ahora referencia a Pacientes en lugar de Usuarios)
CREATE TABLE IF NOT EXISTS Citas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_paciente INT NOT NULL,
    id_medico INT NOT NULL,
    fecha DATE NOT NULL,
    hora TIME NOT NULL,
    observaciones TEXT NULL,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    fecha_actualizacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (id_paciente) REFERENCES Pacientes(id) ON DELETE CASCADE,
    FOREIGN KEY (id_medico) REFERENCES Medicos(id) ON DELETE CASCADE
);

-- Tabla de Horarios de Médicos
CREATE TABLE IF NOT EXISTS Horarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_medico INT NOT NULL,
    dia_semana ENUM('Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo') NOT NULL,
    hora_inicio TIME NOT NULL,
    hora_fin TIME NOT NULL,
    estado ENUM('disponible', 'ocupado') NOT NULL DEFAULT 'disponible',
    FOREIGN KEY (id_medico) REFERENCES Medicos(id) ON DELETE CASCADE
);

-- Insertar Permisos (si no existen)
INSERT IGNORE INTO permiso (permiso) VALUES
('Escritorio'),
('Citas'),
('Medicos');

-- Insertar Usuarios (incluyendo el Admin)
INSERT IGNORE INTO Usuarios (nombre, apellido, email, nombre_usuario, password_hash, cedula, telefono, direccion) VALUES
('Admin', 'Admin', 'admin@hospital.com', 'admin', '123', '001-23456789', '1234567890', 'Dirección Admin'),
('Juan', 'Pérez', 'juan@hospital.com', 'juanp', '123', '001-23456780', '1234567891', 'Dirección Juan'),
('Maria', 'González', 'maria@hospital.com', 'mariag', '123', '001-23456781', '1234567892', 'Dirección Maria'),
('Jose', 'Martinez', 'jose@hospital.com', 'josem', '123', '001-23456736', '1234523892', 'Dirección Jose');

-- Relación entre Usuarios y Permisos (si no existen)
INSERT IGNORE INTO usuario_permiso (id_usuario, id_permiso) VALUES
(1, 1), -- Admin 
(1, 2), 
(1, 3), 
(2, 1), -- Juan 
(2, 2), 
(2, 3), 
(3, 1), -- Maria 
(4, 1), -- Jose 
(4, 2), 
(4, 3);

-- Insertar Especialidades Médicas (si no existen)
INSERT IGNORE INTO Especialidades (nombre, descripcion) VALUES
('Cardiología', 'Especialidad en enfermedades del corazón'),
('Pediatría', 'Especialidad en la atención de niños'),
('Neurología', 'Especialidad en el sistema nervioso');

-- Insertar Médicos (si no existen)
INSERT IGNORE INTO Medicos (id_usuario, id_especialidad, experiencia) VALUES
(2, 1, '5 años de experiencia en Cardiología'),
(3, 2, '3 años de experiencia en Pediatría'),
(4, 3, '8 años de experiencia en Neurología');

-- Insertar Pacientes (si no existen)
INSERT IGNORE INTO Pacientes (nombre, apellido, email, cedula, telefono) VALUES
('Carlos', 'Sánchez', 'carlos@paciente.com', '001-98765432', '0987654321'),
('Laura', 'Martínez', 'laura@paciente.com', '001-98765433', '0987654322'),
('Pedro', 'Jiménez', 'pedro@paciente.com', '001-98765434', '0987654323');

-- Insertar Citas (si no existen)
INSERT IGNORE INTO Citas (id_paciente, id_medico, fecha, hora, observaciones) VALUES
(1, 1, '2025-03-15', '10:00:00', 'Chequeo anual'),
(2, 2, '2025-03-16', '11:00:00', 'Consulta por fiebre'),
(3, 3, '2025-03-17', '09:00:00', 'Revisión de migrañas');

-- Insertar Horarios de Médicos (si no existen)
INSERT IGNORE INTO Horarios (id_medico, dia_semana, hora_inicio, hora_fin, estado) VALUES
(1, 'Lunes', '08:00:00', '14:00:00', 'disponible'),
(2, 'Martes', '09:00:00', '15:00:00', 'disponible'),
(3, 'Miércoles', '10:00:00', '16:00:00', 'disponible');
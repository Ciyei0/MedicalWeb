-- Crear la Base de Datos si no existe
CREATE DATABASE IF NOT EXISTS medicalweb;
USE medicalweb;

-- Tabla de Permisos
CREATE TABLE permiso (
    id INT AUTO_INCREMENT PRIMARY KEY,
    permiso VARCHAR(50) NOT NULL UNIQUE
);

INSERT INTO permiso (permiso) VALUES
('Escritorio'),
('Citas');

-- Tabla de Usuarios (Solo Médicos y Administración)
CREATE TABLE Usuarios (
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

-- Relación entre Usuarios y Permisos (Muchos a Muchos)
CREATE TABLE usuario_permiso (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT NOT NULL,
    id_permiso INT NOT NULL,
    UNIQUE (id_usuario, id_permiso),
    FOREIGN KEY (id_usuario) REFERENCES Usuarios(id) ON DELETE CASCADE,
    FOREIGN KEY (id_permiso) REFERENCES permiso(id) ON DELETE CASCADE
);

-- Tabla de Especialidades Médicas
CREATE TABLE Especialidades (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    descripcion TEXT NULL
);

-- Tabla de Médicos (Usuarios con especialidad)
CREATE TABLE Medicos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT NOT NULL,
    id_especialidad INT NOT NULL,
    experiencia TEXT NULL,
    FOREIGN KEY (id_usuario) REFERENCES Usuarios(id) ON DELETE CASCADE,
    FOREIGN KEY (id_especialidad) REFERENCES Especialidades(id) ON DELETE CASCADE
);

-- Tabla de Pacientes (Independiente de Usuarios)
CREATE TABLE Pacientes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL,
    apellido VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    telefono VARCHAR(20) NULL,
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabla de Citas (Ahora referencia a Pacientes en lugar de Usuarios)
CREATE TABLE Citas (
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
CREATE TABLE Horarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_medico INT NOT NULL,
    dia_semana ENUM('Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo') NOT NULL,
    hora_inicio TIME NOT NULL,
    hora_fin TIME NOT NULL,
    estado ENUM('disponible', 'ocupado') NOT NULL DEFAULT 'disponible',
    FOREIGN KEY (id_medico) REFERENCES Medicos(id) ON DELETE CASCADE
);

ALTER TABLE Pacientes ADD COLUMN cedula VARCHAR(20) NULL UNIQUE;
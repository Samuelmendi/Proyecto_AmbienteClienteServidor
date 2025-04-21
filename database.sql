-- Crear base de datos y usarla
DROP DATABASE IF EXISTS medicare;
CREATE DATABASE medicare CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE medicare;

-- Tabla usuarios
CREATE TABLE usuarios (
  usuario_id INT NOT NULL AUTO_INCREMENT,
  nombre VARCHAR(100) NOT NULL,
  apellidos VARCHAR(100) NOT NULL,
  correo VARCHAR(100) NOT NULL UNIQUE,
  contrasena VARCHAR(255) NOT NULL,
  telefono VARCHAR(20) NOT NULL,
  fecha_registro DATE NOT NULL,
  tipo ENUM('paciente','medico','admin') NOT NULL,
  activo TINYINT(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (usuario_id)
);

-- Tabla pacientes
CREATE TABLE pacientes (
  paciente_id INT NOT NULL AUTO_INCREMENT,
  usuario_id INT NOT NULL,
  fecha_nacimiento DATE NOT NULL,
  genero ENUM('masculino','femenino','otro') NOT NULL,
  direccion VARCHAR(500) NOT NULL,
  numero_seguro VARCHAR(100) NOT NULL,
  historial TEXT NOT NULL,
  PRIMARY KEY (paciente_id),
  FOREIGN KEY (usuario_id) REFERENCES usuarios(usuario_id) ON DELETE CASCADE
);

-- Tabla medicos
CREATE TABLE medicos (
  medico_id INT NOT NULL AUTO_INCREMENT,
  usuario_id INT NOT NULL,
  especialidad VARCHAR(100) NOT NULL,
  biografia TEXT NOT NULL,
  numero_licencia VARCHAR(100) NOT NULL,
  anos_experiencia INT UNSIGNED NOT NULL,
  horario_inicio TIME NOT NULL,
  horario_fin TIME NOT NULL,
  dias_laborables VARCHAR(100) NOT NULL,
  PRIMARY KEY (medico_id),
  FOREIGN KEY (usuario_id) REFERENCES usuarios(usuario_id) ON DELETE CASCADE
);

-- Tabla especialidades
CREATE TABLE especialidades (
  especialidad_id INT NOT NULL AUTO_INCREMENT,
  nombre VARCHAR(100) NOT NULL,
  descripcion VARCHAR(1000) NOT NULL,
  PRIMARY KEY (especialidad_id)
);

-- Tabla medico_especialidad
CREATE TABLE medico_especialidad (
  medico_especialidad_id INT NOT NULL AUTO_INCREMENT,
  medico_id INT NOT NULL,
  especialidad_id INT NOT NULL,
  PRIMARY KEY (medico_especialidad_id),
  FOREIGN KEY (medico_id) REFERENCES medicos(medico_id) ON DELETE CASCADE,
  FOREIGN KEY (especialidad_id) REFERENCES especialidades(especialidad_id) ON DELETE CASCADE
);

-- Tabla citas
CREATE TABLE citas (
  cita_id INT NOT NULL AUTO_INCREMENT,
  paciente_id INT NOT NULL,
  medico_id INT NOT NULL,
  fecha_hora DATETIME NOT NULL,
  estado ENUM('pendiente','confirmada','cancelada','completada') NOT NULL DEFAULT 'pendiente',
  motivo TEXT NOT NULL,
  notas TEXT,
  fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (cita_id),
  FOREIGN KEY (paciente_id) REFERENCES pacientes(paciente_id) ON DELETE CASCADE,
  FOREIGN KEY (medico_id) REFERENCES medicos(medico_id) ON DELETE CASCADE
);

-- Tabla historial_paciente
CREATE TABLE historial_paciente (
  historial_id INT NOT NULL AUTO_INCREMENT,
  paciente_id INT NOT NULL,
  medico_id INT NOT NULL,
  fecha DATE NOT NULL,
  diagnostico TEXT NOT NULL,
  tratamiento TEXT NOT NULL,
  observaciones TEXT,
  PRIMARY KEY (historial_id),
  FOREIGN KEY (paciente_id) REFERENCES pacientes(paciente_id) ON DELETE CASCADE,
  FOREIGN KEY (medico_id) REFERENCES medicos(medico_id) ON DELETE CASCADE
);

-- Tabla horarios_disponibles
CREATE TABLE horarios_disponibles (
  horario_id INT NOT NULL AUTO_INCREMENT,
  medico_id INT NOT NULL,
  fecha DATE NOT NULL,
  hora_inicio TIME NOT NULL,
  hora_fin TIME NOT NULL,
  disponible TINYINT(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (horario_id),
  FOREIGN KEY (medico_id) REFERENCES medicos(medico_id) ON DELETE CASCADE
);

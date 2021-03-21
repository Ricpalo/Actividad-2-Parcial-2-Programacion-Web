DROP DATABASE IF EXISTS sw17_pacientes;
CREATE DATABASE IF NOT EXISTS sw17_pacientes DEFAULT CHARACTER SET utf8;
USE sw17_pacientes;

CREATE TABLE IF NOT EXISTS pacientes(
    id_paciente INTEGER UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
    nombre_paciente VARCHAR(60) NOT NULL,
    fecha_ingreso_paciente DATE NOT NULL,
    curp_paciente VARCHAR(30) UNIQUE NOT NULL
);

CREATE TABLE IF NOT EXISTS diagnosticos_paciente(
    id_diagnostico INTEGER UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
    text_diagnostico TEXT NOT NULL,
    fecha_diagnostico DATE NOT NULL,
    diagnostico_por VARCHAR(60) NOT NULL,
    fk_paciente INTEGER UNSIGNED NOT NULL,
    FOREIGN KEY (fk_paciente) REFERENCES pacientes(id_paciente)
);

CREATE TABLE IF NOT EXISTS medicacion_paciente(
    id_medicamento INTEGER UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
    nombre_medicamento VARCHAR(40) NOT NULL,
    dosis_medicamento VARCHAR(40) NOT NULL,
    fecha_asignacion DATE NOT NULL,
    fk_paciente INTEGER UNSIGNED NOT NULL,
    FOREIGN KEY (fk_paciente) REFERENCES pacientes(id_paciente)
);

CREATE TABLE IF NOT EXISTS tratamiento_paciente(
    id_tratamiento INTEGER UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
    texto_tratamiento TEXT NOT NULL,
    fecha_tratamiento DATE NOT NULL,
    fk_paciente INTEGER UNSIGNED NOT NULL,
    FOREIGN KEY (fk_paciente) REFERENCES pacientes(id_paciente)
);

CREATE TABLE IF NOT EXISTS visitas_paciente(
    id_visita INTEGER UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
    fk_paciente INTEGER UNSIGNED NOT NULL,
    fecha_visita DATE NOT NULL,
    comentario_visita TEXT NOT NULL
);
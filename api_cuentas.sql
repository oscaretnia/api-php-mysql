
CREATE DATABASE api_cuentas;

CREATE TABLE cuentas (
    numero VARCHAR(11) PRIMARY KEY,
    propietario VARCHAR(100) NOT NULL,
    dinero_ingresado INTEGER NOT NULL,
    fecha_creacion DATE NOT NULL
);




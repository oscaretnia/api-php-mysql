<?php

function obtenerCuenta($conexion, $numero) {

    $sql = "SELECT * FROM cuentas WHERE numero = :numero";

    $sentencia = $conexion->prepare($sql);
    $sentencia->bindValue(':numero', $numero);
    $sentencia->execute();

    $respuesta = $sentencia->fetch(PDO::FETCH_ASSOC);

    if ($respuesta) {
        responderPeticion($respuesta);
    } else {
        peticionInvalida(404, "Not Found", "No encontrado");
    }
}

function obtenerCuentas($conexion) {
    
    $sentencia = $conexion->prepare("SELECT * FROM cuentas");
    $sentencia->execute();
    $sentencia->setFetchMode(PDO::FETCH_ASSOC);
    $respuesta = $sentencia->fetchAll();
    responderPeticion($respuesta);
}

function crearCuenta($conexion, $entrada) { 
    
    $sql = "INSERT INTO cuentas (numero, propietario, dinero_ingresado, fecha_creacion) VALUES (:numero, :propietario, :dinero_ingresado, :fecha_creacion)";
    
    try {        
        $sentencia = $conexion->prepare($sql);
        asociarParametros($sentencia, $entrada);
        $sentencia->execute();
        
        responderPeticion($entrada);
        
    } catch (PDOException $exception) {
        peticionInvalida(400, "Bad Request", "Error en la peticion");
    }
}

function eliminarCuenta($conexion, $numero) {
    
    try {
        $sql = "DELETE FROM cuentas WHERE numero = :numero";
        $sentencia = $conexion->prepare($sql);
        $sentencia->bindValue(':numero', $numero);
        $sentencia->execute();
        
        responderPeticion("Cuenta eliminada");
                
    } catch (PDOException $exception) {
        peticionInvalida(400, "Bad Request", "Error en la peticion");
    }
}

function actualizarCuenta($conexion, $entrada) {
    
    $numero = $entrada['numero'];
    $campos = obtenerParametros($entrada);

    $sql = "UPDATE cuentas SET $campos WHERE numero = $numero";
    
    try {
        $sentencia = $conexion->prepare($sql);
        asociarParametros($sentencia, $entrada);
        $sentencia->execute();
        
        responderPeticion("Cuenta actualizada");
        
    } catch(PDOException $exception) {
        peticionInvalida(400, "Bad Request", "Error en la peticion");
    }
}

function peticionInvalida($codigo, $estado, $mensaje) {
    header("HTTP/1.1 $codigo $estado");
    echo json_encode(["mensaje" => $mensaje, "estado" => $codigo]);
    exit();
}

function responderPeticion($respuesta) {
    header('HTTP/1.1 200 OK');
    echo json_encode(["estado" => 200, "respuesta" => $respuesta]);
    exit();
}

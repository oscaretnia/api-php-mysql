<?php

include 'config.php';
include 'util.php';
include 'funciones.php';

$conexion = conectar($db);

$metodo = filter_input(INPUT_SERVER,'REQUEST_METHOD',FILTER_SANITIZE_STRING);

switch ($metodo) {
    case 'GET':
        if (filter_has_var(INPUT_GET, 'numero')) {
            $numero = filter_input(INPUT_GET,'numero',FILTER_SANITIZE_STRING);
            obtenerCuenta($conexion, $numero);
        } else {
            obtenerCuentas($conexion);
        }
        break;
    case 'POST':
        $entrada = filter_input_array(INPUT_POST);
        crearCuenta($conexion, $entrada);
        break;
    case 'PUT':
        $entrada = filter_input_array(INPUT_GET);
        actualizarCuenta($conexion, $entrada);
        break;
    case 'DELETE':
        $numero = filter_input(INPUT_GET,'numero',FILTER_SANITIZE_STRING);
        eliminarCuenta($conexion, $numero);
        break;
    default:
        peticionInvalida(405, "Method Not Allowed", "Metodo no permitido");
        break;
}
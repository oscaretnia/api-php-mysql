<?php

//Abrir la conexion de la base de datos con PDO
function conectar ($db) 
  {
      try {
          $con = new PDO("mysql:host={$db['host']};dbname={$db['db']}", $db['username'], $db['password']);

          $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

          return $con;
      } catch (PDOException $exception) {
          exit($exception->getMessage());
      }
  }

//Obtener parametros para actualizaciones
function obtenerParametros($entrada) 
{
    $filtro = [];
    
    foreach ($entrada as $parametro => $valor)
    {
       array_push($filtro, "$parametro=:$parametro");
    }
    
    return implode(", ", $filtro);    
}

//Asociar parametros en SQL
function asociarParametros($sentencia, $parametros) 
{
    foreach ($parametros as $parametro => $valor)
    {
        if ($parametro == 'dinero_ingresado')
        {
            $sentencia->bindValue(':' . $parametro, $valor, PDO::PARAM_INT);
        }
        else 
        {
            $sentencia->bindvalue(':' . $parametro, $valor);
        }
        
    }
    return $sentencia;
}


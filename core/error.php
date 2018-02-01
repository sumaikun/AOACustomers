<?php
// función de gestión de errores
function miGestorDeErrores($errno, $errstr, $errfile, $errline)
{
    if (!(error_reporting() & $errno)) {
        // Este código de error no está incluido en error_reporting
        return;
    }

    switch ($errno) {
    case E_USER_ERROR:
        echo "<b>Mi ERROR</b> [$errno] $errstr<br />\n";
        echo "  Error fatal en la línea $errline en el archivo $errfile";
        echo ", PHP " . PHP_VERSION . " (" . PHP_OS . ")<br />\n";
        echo "Abortando...<br />\n";
        exit(1);
        break;

    case E_USER_WARNING:
        echo "<b>Mi WARNING</b> [$errno] $errstr $errfile $errline<br />\n";
        break;
        exit;
    case E_USER_NOTICE:
        echo "<b>Mi NOTICE</b> [$errno] $errstr $errfile $errline<br />\n";
        exit;
        break;
    case E_NOTICE:
        echo "<b>NOTICE</b> [$errno] $errstr $errfile $errline <br />\n";
        exit;
        break;
    default:
        echo "Tipo de error desconocido: [$errno] $errstr $errfile $errline<br />\n";
        exit;
        break;
    }

    /* No ejecutar el gestor de errores interno de PHP */
    return true;
}

// función para probar el manejo de errores
function scale_by_log($vect, $scale)
{
    if (!is_numeric($scale) || $scale <= 0) {
        trigger_error("log(x) para x <= 0 no está definido, usó: scale = $scale", E_USER_ERROR);
    }

    if (!is_array($vect)) {
        trigger_error("Vector de entrada incorrecto, se esperaba una matriz de valores", E_USER_WARNING);
        return null;
    }

    $temp = array();
    foreach($vect as $pos => $valor) {
        if (!is_numeric($valor)) {
            trigger_error("El valor en la posición $pos no es un número, usando 0 (cero)", E_USER_NOTICE);
            $valor = 0;
        }
        $temp[$pos] = log($scale) * $valor;
    }

    return $temp;
}

// establecer el gestro de errores definido por el usuario
$gestor_errores_antiguo = set_error_handler("miGestorDeErrores");
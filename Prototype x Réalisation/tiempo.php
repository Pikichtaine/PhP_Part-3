<?php
function tiempoTranscurrido($fecha) {
    $tiempo = time() - strtotime($fecha);

    if ($tiempo < 60) {
        return "hace unos segundos";
    } elseif ($tiempo < 3600) {
        return "hace " . floor($tiempo / 60) . " min";
    } elseif ($tiempo < 86400) {
        return "hace " . floor($tiempo / 3600) . " horas";
    } elseif ($tiempo < 172800) {
        return "ayer";
    } else {
        return "hace " . floor($tiempo / 86400) . " días";
    }
}
?>
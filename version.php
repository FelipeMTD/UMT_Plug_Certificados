<?php
// Previene el acceso directo al archivo por seguridad
defined('MOODLE_INTERNAL') || die();

$plugin->component = 'local_descargacertificados'; // Nombre del sistema
$plugin->version   = 2026022003;                   // Fecha de versión (AAAAMMDDXX)
$plugin->requires  = 2022112800;                   // Requiere Moodle 4.1 o superior
$plugin->maturity  = MATURITY_STABLE;              // Estado de desarrollo
$plugin->release   = '2.1';                        // Versión para humanos

// Aquí declaramos la dependencia estricta de tool_certificate
$plugin->dependencies = [
    'tool_certificate' => ANY_VERSION
];
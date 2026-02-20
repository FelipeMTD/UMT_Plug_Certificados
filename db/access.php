<?php
// Ruta: local/descargacertificados/db/access.php
defined('MOODLE_INTERNAL') || die();

$capabilities = array(
    // Creamos nuestro permiso personalizado
    'local/descargacertificados:download' => array(
        'captype' => 'read',
        'contextlevel' => CONTEXT_SYSTEM,
        'archetypes' => array(
            'manager' => CAP_ALLOW, // Los gestores/administradores lo tendrán por defecto
        )
    ),
);
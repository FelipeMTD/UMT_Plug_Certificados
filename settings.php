<?php
// Ruta: local/descargacertificados/settings.php
defined('MOODLE_INTERNAL') || die();

// Usamos la variable global $hassiteconfig para evitar errores de carga
if ($hassiteconfig) {
    $enlace = new admin_externalpage(
        'local_descargacertificados',
        get_string('pluginname', 'local_descargacertificados'),
        new moodle_url('/local/descargacertificados/index.php'),
        'local/descargacertificados:download' // <-- Moodle hará la validación aquí adentro de forma segura
        // 'moodle/site:config' // <-- TRUCO: Volvemos al permiso nativo temporalmente
    );

    $ADMIN->add('reports', $enlace);
}
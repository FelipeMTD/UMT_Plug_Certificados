<?php
// Ruta: local/descargacertificados/settings.php
defined('MOODLE_INTERNAL') || die();

// Esta línea permite que cualquier persona con el permiso vea el menú
if (has_capability('local/descargacertificados:download', context_system::instance())) {
    
    $enlace = new admin_externalpage(
        'local_descargacertificados',
        get_string('pluginname', 'local_descargacertificados'),
        new moodle_url('/local/descargacertificados/index.php'),
        'local/descargacertificados:download' // Moodle valida el acceso aquí también
    );

    // Lo añadimos a la sección de informes
    $ADMIN->add('reports', $enlace);
}
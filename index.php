<?php
// Ruta: [RAIZ_DE_MOODLE]/local/descargacertificados/index.php

require_once(__DIR__ . '/../../config.php');
require_once($CFG->libdir.'/filelib.php');

// 1. Configuración de seguridad y contexto
require_login();
$context = context_system::instance();
require_capability('local/descargacertificados:download', $context);

// 2. Configuración visual de la página
$url = new moodle_url('/local/descargacertificados/index.php');
$PAGE->set_url($url);
$PAGE->set_context($context);
$PAGE->set_title(get_string('pluginname', 'local_descargacertificados'));
$PAGE->set_heading(get_string('search_title', 'local_descargacertificados'));

// 3. Instanciar el formulario
require_once(__DIR__ . '/classes/form/search_form.php');
$mform = new \local_descargacertificados\form\search_form();

// 4. Lógica de procesamiento
if ($data = $mform->get_data()) {
    global $DB;
    
    $conditions = [];
    $params = [];
    
    if (!empty($data->username)) {
        $conditions[] = 'username = :username';
        $params['username'] = $data->username;
    }
    if (!empty($data->email)) {
        $conditions[] = 'email = :email';
        $params['email'] = $data->email;
    }
    
    $where = implode(' OR ', $conditions);
    $user = $DB->get_record_select('user', $where, $params, 'id, firstname, lastname, username', IGNORE_MULTIPLE);
    
    if (!$user) {
        echo $OUTPUT->header();
        echo $OUTPUT->notification(get_string('error_notfound', 'local_descargacertificados'), 'error');
        $mform->display();
        echo $OUTPUT->footer();
        exit;
    }
    
    // FASE 4: Validar certificados filtrando por PREFIJO "Free"
    $palabra_clave = 'Free%'; 
    
    $sql = "SELECT ci.id, ci.timecreated, ci.code, ct.name as templatename
            FROM {tool_certificate_issues} ci
            JOIN {tool_certificate_templates} ct ON ct.id = ci.templateid
            WHERE ci.userid = :userid 
            AND ct.name LIKE :palabraclave";
            
    $certificados = $DB->get_records_sql($sql, ['userid' => $user->id, 'palabraclave' => $palabra_clave]);
    
    if (empty($certificados)) {
        echo $OUTPUT->header();
        echo $OUTPUT->notification('El usuario fue encontrado, pero no tiene certificados emitidos con el prefijo Free.', 'warning');
        $mform->display();
        echo $OUTPUT->footer();
        exit;
    }
    
    // FASE 5: Empaquetado en ZIP
    $fs = get_file_storage();
    $syscontext = context_system::instance(); // Contexto 1 
    
    $zip = new zip_archive();
    $zipfilename = 'Certificados_' . $user->username . '_' . date('Ymd_His') . '.zip';
    $tempzip = make_request_directory() . '/' . $zipfilename;
    
    $zip->open($tempzip, zip_archive::CREATE);
    $archivos_agregados = 0;
    
    foreach ($certificados as $cert) {
        // Buscamos en 'issues'
        $files = $fs->get_area_files($syscontext->id, 'tool_certificate', 'issues', $cert->id, 'filename', false);
        
        foreach ($files as $file) {
            if (!$file->is_directory()) {
                $nombre_original = $file->get_filename();
                $nombre_limpio = clean_param($cert->templatename, PARAM_FILE);
                $nombre_pdf = $nombre_limpio . '_' . $nombre_original;
                
                // ¡AQUÍ ESTÁ LA LÍNEA CORREGIDA! 
                // Extraemos el contenido del PDF y lo metemos al ZIP correctamente
                $zip->add_file_from_string($nombre_pdf, $file->get_content());
                $archivos_agregados++;
            }
        }
    }
    
    $zip->close(); 
    
    if ($archivos_agregados > 0) {
        // Enviar el archivo al navegador para la descarga
        send_temp_file($tempzip, $zipfilename); 
        exit;
    } else {
        echo $OUTPUT->header();
        echo $OUTPUT->notification('Error: Los certificados están en base de datos, pero la carpeta "issues" devolvió 0 archivos físicos.', 'error');
        $mform->display();
        echo $OUTPUT->footer();
        exit;
    }
}

// Pantalla inicial
echo $OUTPUT->header();
$mform->display();
echo $OUTPUT->footer();
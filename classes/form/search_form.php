<?php
// Ruta: [RAIZ_DE_MOODLE]/local/descargacertificados/classes/form/search_form.php

namespace local_descargacertificados\form;

defined('MOODLE_INTERNAL') || die();

// ¡ESTA ES LA LÍNEA QUE FALTABA PARA EVITAR EL ERROR 500!
global $CFG; 
require_once($CFG->libdir . '/formslib.php');

class search_form extends \moodleform {
    public function definition() {
        $mform = $this->_form;

        // Campo 1: Username
        $mform->addElement('text', 'username', get_string('username', 'local_descargacertificados'));
        $mform->setType('username', PARAM_USERNAME);

        // Campo 2: Email
        $mform->addElement('text', 'email', get_string('email', 'local_descargacertificados'));
        $mform->setType('email', PARAM_EMAIL);

        // Botón de búsqueda
        $this->add_action_buttons(false, get_string('search_button', 'local_descargacertificados'));
    }

    // Validación: Obligar a que llenen al menos un campo
    public function validation($data, $files) {
        $errors = parent::validation($data, $files);
        
        if (empty($data['username']) && empty($data['email'])) {
            $errors['username'] = get_string('error_nofields', 'local_descargacertificados');
            $errors['email'] = get_string('error_nofields', 'local_descargacertificados');
        }
        
        return $errors;
    }
}
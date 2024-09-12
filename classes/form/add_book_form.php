<?php

/**
 * Version details
 *
 * @package    local_library
 * @copyright  2024  joytun  (joytunsultana09171@gmail.com)
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
// namespace local_library\form;

use core_reportbuilder\local\filters\select;
use gradereport_singleview\local\ui\element;



// use moodleform;
require_once("$CFG->libdir/formslib.php");

class add_book_form extends moodleform {
    public function definition() {

        global $CGF;
        
        $mform = $this->_form;

        $mform->addElement('text', 'title', get_string('title', 'local_library'));
        $mform->setType('title', PARAM_TEXT);
        $mform->addRule('title', null, 'required', null, 'client');

        $mform->addElement('text', 'author', get_string('author', 'local_library'));
        $mform->setType('author', PARAM_TEXT);
        $mform->addRule('author', null, 'required', null, 'client');

        $mform->addElement('text', 'isbn', get_string('isbn', 'local_library'));
        $mform->setType('isbn', PARAM_TEXT);
        $mform->addRule('isbn', null, 'required', null, 'client');

        $mform->addElement('text', 'copies', get_string('copies', 'local_library'));
        $mform->setType('copies', PARAM_INT);
        $mform->addRule('copies', null, 'required', null, 'client');

        $this->add_action_buttons();
    }
}

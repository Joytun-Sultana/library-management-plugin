<?php

/**
 * Version details
 *
 * @package    local_library
 * @copyright  2024  joytun  (joytunsultana09171@gmail.com)
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once(__DIR__ . '/../../config.php');

require_login();
$context = context_system::instance();

require_once($CFG->dirroot . '/local/library/classes/form/add_book_form.php');

global $DB;


$PAGE->set_url(new moodle_url('/local/library/edit.php'));
$PAGE->set_context($context);
$PAGE->set_title('Edit page');

$id = optional_param('id', 0, PARAM_INT);
$mform = new add_book_form();

if ($id) {
   
    $record = $DB->get_record('library_books', array('id' => $id), '*', MUST_EXIST);
    $mform->set_data($record);
} 
else {

    $record = new stdClass();
    $record->id = 0;
    $record->task = '';  
}

echo $OUTPUT->header();

if ($mform->is_cancelled()) {
   
    redirect($CFG->wwwroot . '/local/library/manage.php', 'You cancelled the form');
}
else if ($data = $mform->get_data()) {
    
    $record = new stdClass();
    $record->title = $data->title;
    $record->author = $data->author; 
    $record->isbn = $data->isbn;  
    $record->copies = $data->copies; 

    if ($id) {
        $record->id = $id;
        $DB->update_record('library_books', $record);
    } 
    else {
        $DB->insert_record('library_books', $record);
    }
    redirect(new moodle_url('/local/library/manage.php'), 'Book info saved successfully');
}

$mform->display();

echo $OUTPUT->footer();
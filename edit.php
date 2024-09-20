<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Edit or Create a record.
 *
 * @package    local_library
 * @copyright  2024 Joytun
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
$PAGE->set_heading('Book Details');

if (! has_capability('local/library:managebooks', context_system::instance())) {
    redirect(new moodle_url('/local/library/manage.php'), "Sorry You Don't have access to that page");
}

$id = optional_param('id', 0, PARAM_INT);
$mform = new add_book_form();

if ($id) {
    $record = $DB->get_record('library_books', ['id' => $id], '*', MUST_EXIST);
    $mform->set_data($record);
} else {

    $record = new stdClass();
    $record->id = 0;
    $record->task = '';
}

echo $OUTPUT->header();

if ($mform->is_cancelled()) {
    redirect($CFG->wwwroot . '/local/library/manage.php', 'You cancelled the form');
} else if ($data = $mform->get_data()) {
    $record = new stdClass();
    $record->title = $data->title;
    $record->author = $data->author;
    $record->isbn = $data->isbn;
    $record->copies = $data->copies;

    if ($id) {
        $record->id = $id;
        $DB->update_record('library_books', $record);
    } else {
        $DB->insert_record('library_books', $record);
    }
    redirect(new moodle_url('/local/library/manage.php'), 'Book info saved successfully');
}

$mform->display();

echo $OUTPUT->footer();


<?php

/**
 * Version details
 *
 * @package    local_library
 * @copyright  2024  joytun  (joytunsultana09171@gmail.com)
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */


function local_library_extend_navigation() {
    global $PAGE;
    $PAGE->requires->css('/local/library/styles.css');
}


defined('MOODLE_INTERNAL') || die();


function local_library_delete_book($bookid) {
    global $DB;

    if (!$DB->record_exists('library_books', array('id' => $bookid))) {
        throw new moodle_exception('invalidbookid', 'local_library');
    } 
    else {
        return $DB->delete_records('library_books', array('id' => $bookid));
    }
}



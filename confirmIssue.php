<?php

/**
 * Version details
 *
 * @package    local_library
 * @copyright  2024  joytun
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once(__DIR__.'/../../config.php');
require_once('./lib.php');

require_login();
$context = context_system::instance();

if (!has_capability('local/library:managebooks', $context)) {
    throw new moodle_exception('nopermissions', 'error', '', 'manage books');
}

$issueid = required_param('issueid', PARAM_INT);

$issue = $DB->get_record('library_issues', array('id' => $issueid), '*', MUST_EXIST);
$book = $DB->get_record('library_books', array('id' => $issue->bookid), '*', MUST_EXIST);


if ($book->copies < 1) {
    throw new moodle_exception('nocopies', 'local_library');
}

$transaction = $DB->start_delegated_transaction();

try {
    $DB->set_field('library_books', 'copies', $book->copies - 1, array('id' => $book->id));

    $DB->update_record('library_issues', array('id' => $issue->id, 'issuedate' => date('Y-m-d H:i:s', time())));

    $transaction->allow_commit();
    $DB->delete_records('library_issues',['id'=> $issue->id]);
    redirect(new moodle_url('/local/library/issueBooks.php'), 'Book issue confirmed and copies updated.', null, \core\output\notification::NOTIFY_SUCCESS);
   
} 
catch (Exception $e) {
    $transaction->rollback($e);
    throw $e;
}

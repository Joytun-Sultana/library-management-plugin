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

require_once(__DIR__.'/../../config.php');
require_once('./lib.php');

require_login();
$context = context_system::instance();

if (!has_capability('local/library:managebooks', $context)) {
    throw new moodle_exception('nopermissions', 'error', '', 'manage books');
}

$issueid = required_param('issueid', PARAM_INT);

$issue = $DB->get_record('library_issues', ['id' => $issueid], '*', MUST_EXIST);
$book = $DB->get_record('library_books', ['id' => $issue->bookid], '*', MUST_EXIST);


if ($book->copies < 1) {
    throw new moodle_exception('nocopies', 'local_library');
}

$transaction = $DB->start_delegated_transaction();

try {

    $DB->set_field('library_books', 'copies', $book->copies - 1, ['id' => $book->id]);

    $DB->update_record('library_issues', ['id' => $issue->id, 'issuedate' => date('Y-m-d H:i:s', time())]);

    $transaction->allow_commit();
    $DB->delete_records('library_issues', ['id' => $issue->id]);
    redirect(new moodle_url('/local/library/issueBooks.php'),
    'Book issue confirmed and copies updated.', null, \core\output\notification::NOTIFY_SUCCESS);
} catch (Exception $e) {

    $transaction->rollback($e);
    throw $e;
}

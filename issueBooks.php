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

$context = context_system::instance();
require_login();

if (!has_capability('local/library:managebooks', $context)) {
    throw new moodle_exception('nopermissions', 'error', '', 'manage books');
}


$PAGE->set_url(new moodle_url('/local/library/issueBooks.php'));
$PAGE->set_context($context);
$PAGE->set_title('Manage Book Issues');
$PAGE->set_heading('Manage Book Issues');

echo $OUTPUT->header();


$issues = $DB->get_records_sql("
    SELECT li.id, li.bookid, li.userid, li.issuedate, lb.title, lb.copies, u.firstname, u.lastname
    FROM {library_issues} li
    JOIN {library_books} lb ON lb.id = li.bookid
    JOIN {user} u ON u.id = li.userid
    WHERE li.returndate IS NULL
");

if (!$issues) {
    echo html_writer::div('No books requested for issue.', 'alert alert-info');
} else {
    echo html_writer::tag('h3', 'Books Requested for Issue');
    echo '<a style="font-size: 25px;font-weight: bold;color: #307c34;" href="http://localhost/moodle/local/library/manage.php" class="btn">Back to Book List</a>';
    echo '<table class="table">';
    echo '<tr><th>Book Title</th><th>Requested By</th><th>Available Copies</th><th>Issue Date</th><th>Action</th></tr>';

    foreach ($issues as $issue) {
        echo '<tr>';
        echo '<td>' . $issue->title . '</td>';
        echo '<td>' . $issue->firstname . ' ' . $issue->lastname . '</td>';
        echo '<td>' . $issue->copies . '</td>';
        echo '<td>' . userdate($issue->issuedate) . '</td>';
        echo '<td><a href="confirmIssue.php?issueid=' . $issue->id . '" class="btn btn-primary">Confirm Issue</a></td>';
        echo '</tr>';
    }

    echo '</table>';
}

echo $OUTPUT->footer();

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
} 
else {
    echo html_writer::tag('h3', 'Books Requested for Issue');
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

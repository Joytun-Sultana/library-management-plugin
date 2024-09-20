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
require_login();

$context = context_system::instance();
$bookid = required_param('id', PARAM_INT);

// Ensure the book exists.
$book = $DB->get_record('library_books', ['id' => $bookid], '*', MUST_EXIST);

$PAGE->set_url(new moodle_url('/local/library/issue.php', ['id' => $bookid]));
$PAGE->set_context($context);
$PAGE->set_title('Request Issue for ' . $book->title);
$PAGE->set_heading('Request Issue');

echo $OUTPUT->header();

echo '<h1>Request Issue for</h1>';
echo '<h2 style="color: #4CAF50;; font-size: 30px;">'. $book->title. '</h2>';

echo '<p style="font-size: 20px;">'.'Author: ' . $book->author. '</p>';
echo '<p style="font-size: 20px;">'. 'ISBN: ' . $book->isbn . '</p>';
echo '<p style="font-size: 20px;">'. 'Copies available: ' . $book->copies . '</p>';



$existingissue = $DB->get_record('library_issues', ['bookid' => $bookid, 'userid' => $USER->id, 'returndate' => null]);

if ($existingissue) {
    echo html_writer::div('You have already requested for this book.', 'alert alert-danger custom-alert');
} else {

    if ($book->copies > 0) {

        $issuedata = new stdClass();
        $issuedata->bookid = $bookid;
        $issuedata->userid = $USER->id;
        $issuedata->issuedate = date('Y-m-d H:i:s', time());
        $issuedata->returndate = null;
        $DB->insert_record('library_issues', $issuedata);
        echo html_writer::div('Book issue request has been submitted.', 'alert alert-success custom-alert-success');

    } else {
        echo '<p style="color: red; font-size: 25px;"><b>Sorry, the book is not available right now</b></p>';
    }
}
echo '<a style="color: #4CAF50;;font-size: 30px;font-weight: bold;" href="http://localhost/moodle/local/library/manage.php" class="btn">Back to Book List</a>';


echo $OUTPUT->footer();


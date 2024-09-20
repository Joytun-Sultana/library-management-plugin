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

// defined('MOODLE_INTERNAL') || die();
// require_login();
require_once(__DIR__.'/../../config.php');
require_once('./lib.php');
$context = context_system::instance();



global $DB;

$PAGE->set_url(new moodle_url('/local/library/manage.php'));
$PAGE->set_context(context_system::instance());
$PAGE->set_title('Manage Page');

$books = $DB->get_records('library_books');

echo $OUTPUT->header();

$PAGE->requires->js_call_amd('local_library/confirmdelete', 'init', []);

echo html_writer::tag('h2', 'Book List');
echo '<br>';

if (has_capability('local/library:managebooks', context_system::instance())) {
    echo html_writer::link(new moodle_url('/local/library/edit.php'), 'Add Book',
    ['class' => 'btn btn-primary', 'id' => 'add-book-btn']);
    echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
    echo html_writer::link(new moodle_url('/local/library/issueBooks.php'), 'Issue Requests',
    ['class' => 'btn btn-primary']);

}

if ($books) {
    echo '<br>'.'<br>';
    echo '<table id="book-list">';
    echo '<tr>';
    echo '<th>Title</th>';
    echo '<th>Author</th>';
    echo '<th>ISBN</th>';
    echo '<th>Copies</th>';
    if (has_capability('local/library:managebooks', context_system::instance())) {
        echo '<th>Edit</th>';
        echo '<th>Delete</th>';
    } else {
        echo '<th>Issue</th>';
    }
    echo '</tr>';

    foreach ($books as $book) {

        echo '<tr>';
        echo '<td>' . $book->title . '</td>';
        echo '<td>' . $book->author . '</td>';
        echo '<td>' . $book->isbn . '</td>';
        echo '<td>' . $book->copies . '</td>';
        if (has_capability('local/library:managebooks', context_system::instance())) {
            echo '<td>' . '<a href="edit.php?id=' . $book->id . '">Edit</a>'. '</td>';
            echo '<td><button id="delete-btn-' . $book->id . '" class="btn btn-danger delete-btn">Delete</button></td>';
        } else {
            echo '<td>' .'<a href="issue.php?id=' . $book->id . '">Issue</a>'. '</td>';
        }
        echo '</tr>';
    }
    echo '</table>';
    echo '<br>'.'<br>';
}
echo $OUTPUT->footer();




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

require_once('../../config.php');
require_login();


$PAGE->set_url('/local/library/index.php');
$PAGE->set_context(context_system::instance());
$PAGE->set_title(get_string('pluginname', 'local_library'));
$PAGE->set_heading(get_string('pluginname', 'local_library'));

echo $OUTPUT->header();
echo $OUTPUT->heading(get_string('booklist', 'local_library'));


$books = $DB->get_records('library_books');
if ($books) {
    foreach ($books as $book) {
        echo format_text("Title: {$book->title} | Author: {$book->author} | ISBN: {$book->isbn} | Copies: {$book->copies}");
    }
} else {
    echo get_string('nobooks', 'local_library');
}

echo $OUTPUT->footer();

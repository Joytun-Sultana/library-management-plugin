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

defined('MOODLE_INTERNAL') || die();
/**
 * Summary of local_library_extend_navigation
 * @return void
 */
function local_library_extend_navigation() {
    global $PAGE;
    $PAGE->requires->css('/local/library/styles.css');
}


defined('MOODLE_INTERNAL') || die();

/**
 * Summary of local_library_delete_book
 * @return void
 */
function local_library_delete_book($bookid) {
    global $DB;

    if (!$DB->record_exists('library_books', ['id' => $bookid])) {
        throw new moodle_exception('invalidbookid', 'local_library');
    } else {
        return $DB->delete_records('library_books', ['id' => $bookid]);
    }
}



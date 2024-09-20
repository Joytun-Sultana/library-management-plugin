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
require_once($CFG->libdir . "/externallib.php");
require_once($CFG->dirroot . "/local/library/lib.php");
/**
 * Summary of init
 * @return void
 */
class local_library_external extends external_api {
    /**
     * Summary of local_library_external
     * Parameters for delete_book function.
     * @return void
     */
    public static function delete_book_parameters(): external_function_parameters {
        return new external_function_parameters(
            [
                'bookid' => new external_value(PARAM_INT, 'book id'),
            ]
        );
    }
    /**
     * Delete a book from the library.
     *
     * @param int $bookid The ID of the book to delete.
     * @return bool True if the book was successfully deleted.
     * @throws moodle_exception If the book could not be deleted.
     */
    public static function delete_book(int $bookid): array {
        global $DB;

        $warnings = [];

        local_library_delete_book($bookid); // Defined in lib.php.

        return [
        'bookid' => $bookid,
        'warnings' => $warnings,
        ];
    }
    /**
     * Return type for delete_book function.
     *
     * @return external_single_structure
     */
    public static function delete_book_returns() {
        return new external_single_structure(
            [
                'bookid' => new external_value(PARAM_INT, 'book id'),
                'warnings' => new external_warnings(),
            ]
        );
    }
}

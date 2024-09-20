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
require_once("$CFG->libdir/formslib.php");
/**
 * Summary of add_book_form
 * @return void
 */
class add_book_form extends moodleform {
    /**
     * Summary of definition
     * @return void
     */
    public function definition() {
        $mform = $this->_form;

        $mform->addElement('text', 'title', get_string('title', 'local_library'));
        $mform->setType('title', PARAM_TEXT);
        $mform->addRule('title', null, 'required', null, 'client');

        $mform->addElement('text', 'author', get_string('author', 'local_library'));
        $mform->setType('author', PARAM_TEXT);
        $mform->addRule('author', null, 'required', null, 'client');

        $mform->addElement('text', 'isbn', get_string('isbn', 'local_library'));
        $mform->setType('isbn', PARAM_TEXT);
        $mform->addRule('isbn', null, 'required', null, 'client');

        $mform->addElement('text', 'copies', get_string('copies', 'local_library'));
        $mform->setType('copies', PARAM_INT);
        $mform->addRule('copies', null, 'required', null, 'client');

        $this->add_action_buttons();
    }
}

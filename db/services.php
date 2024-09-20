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


defined('MOODLE_INTERNAL') || die;

$services = [
    'Library Service' => [
        'functions' => [
            'local_library_delete_book',  // Defined in lib.php.
        ],
        'restrictedusers' => 0,
        'enabled' => 1,

    ],
];

$functions = [
    'local_library_delete_book' => [
        'classname' => 'local_library_external', // Defined in classes/external.php.
        'methodname' => 'delete_book',
        'classpath' => 'local/library/external.php',
        'description' => 'Delete a Book from Library',
        'type' => 'write',
        'ajax' => true,
        'capabilities' => 'local/library:managebooks',
    ],
];





<?php

/**
 * Version details
 *
 * @package    local_library
 * @copyright  2024  joytun  (joytunsultana09171@gmail.com)
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
*/


defined('MOODLE_INTERNAL') || die;

$services = array(
    'Library Service' => array(
        'functions' => array(
            'local_library_delete_book',  // defined in lib.php
        ),
        'restrictedusers' => 0,
        'enabled' => 1,

    ),
    
);

$functions = array(
    'local_library_delete_book' => array(
        'classname' => 'local_library_external', // defined in classes/external.php
        'methodname' => 'delete_book',
        'classpath' => 'local/library/external.php',
        'description' => 'Delete a Book from Library',
        'type' => 'write',
        'ajax' => true,
        'capabilities' => 'local/library:managebooks'
    ),
);





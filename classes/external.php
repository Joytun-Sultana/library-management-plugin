<?php

/**
 * Version details
 *
 * @package    local_library
 * @copyright  2024  joytun  (joytunsultana09171@gmail.com)
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
 
 require_once($CFG->libdir . "/externallib.php");
 require_once($CFG->dirroot . "/local/library/lib.php");
 


 class local_library_external extends external_api {

    /**
      * Parameters for delete_book function.
      *
      * @return external_function_parameters
      */
    public static function delete_book_parameters():external_function_parameters {
        return new external_function_parameters(
            array(
                'bookid' => new external_value(PARAM_INT, 'book id'),
            )
        );
    }
    
     /**
      * Delete a book from the library.
      *
      * @param int $bookid The ID of the book to delete.
      * @return bool True if the book was successfully deleted.
      * @throws moodle_exception If the book could not be deleted.
      */
     public static function delete_book(int $bookid):array {
         global $DB;

         $warnings = array();

         local_library_delete_book($bookid); // defined in lib.php

         return array(
            'bookid' => $bookid,
            'warnings' => $warnings
        );
     }
 
 
     /**
      * Return type for delete_book function.
      *
      * @return external_single_structure
      */
     public static function delete_book_returns() {
        return new external_single_structure(
            array(
                'bookid' => new external_value(PARAM_INT, 'book id'),
                'warnings' => new external_warnings()
            )
        );
     }
 }
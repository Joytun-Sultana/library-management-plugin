<?php

/**
 * Version details
 *
 * @package    local_library
 * @copyright  2024  joytun
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once(__DIR__.'/../../config.php');
require_login();

$context = context_system::instance();
$bookid = required_param('id', PARAM_INT);

// Ensure the book exists
$book = $DB->get_record('library_books', array('id' => $bookid), '*', MUST_EXIST);

$PAGE->set_url(new moodle_url('/local/library/issue.php', array('id' => $bookid)));
$PAGE->set_context($context);
$PAGE->set_title('Request Issue for ' . $book->title);
$PAGE->set_heading('Request Issue');

echo $OUTPUT->header();


echo '<h1>Request Issue for</h1>';
echo '<h2 style="color: blue;">'. $book->title. '</h2>';

echo '<p style="font-size: 20px;">'.'Author: ' . $book->author. '</p>';
echo '<p style="font-size: 20px;">'. 'ISBN: ' . $book->isbn . '</p>';
echo '<p style="font-size: 20px;">'. 'Copies available: ' . $book->copies . '</p>';


$existing_issue = $DB->get_record('library_issues', array('bookid' => $bookid, 'userid' => $USER->id, 'returndate' => null));

if ($existing_issue) {
    echo html_writer::div('You have already requested this book.', 'alert alert-info');
} 
else {

    if($book->copies >0){

        $issue_data = new stdClass();
        $issue_data->bookid = $bookid;
        $issue_data->userid = $USER->id;
        $issue_data->issuedate = date('Y-m-d H:i:s', time());
        $issue_data->returndate = null; 
        
        $DB->insert_record('library_issues', $issue_data);
        echo html_writer::div('Book issue request has been submitted.', 'alert alert-success');
    }

    else{
        echo '<p style="color: red; font-size: 25px;"><b>Sorry, the book is not available right now</b></p>';
    
    }

}

echo $OUTPUT->footer();

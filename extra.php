<?php

/**
 * Version details
 *
 * @package    local_library
 * @copyright  2024  joytun  (joytunsultana09171@gmail.com)
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
*/

require_once(__DIR__ . '/../../config.php');

$bookid = required_param('id', PARAM_INT); 

require_login();
$context = context_system::instance();
$PAGE->set_url(new moodle_url('/local/library/issue.php', array('id' => $bookid)));
$PAGE->set_context($context);
$PAGE->set_title('Issue Book Request');
//$PAGE->set_heading('Issue Book Request');


global $DB, $USER;
$book = $DB->get_record('library_books', array('id' => $bookid), '*', MUST_EXIST);



if (optional_param('submitissue', false, PARAM_BOOL)) {
   
    $issue_data = new stdClass();
    $issue_data->bookid = $bookid;
    $issue_data->userid = $USER->id;
    $issue_data->issuedate = time();
    $issue_data->status = 'pending';
    
    $DB->insert_record('library_issues', $issue_data);

    redirect(new moodle_url('/local/library/manage.php'), 'Your request has been sent to the admin for approval.', 5);
}

echo $OUTPUT->header();

echo '<h1>Request Issue for</h1>';
echo '<h2 style="color: blue;">'. $book->title. '</h2>';

echo '<p style="font-size: 20px;">'.'Author: ' . $book->author. '</p>';
echo '<p style="font-size: 20px;">'. 'ISBN: ' . $book->isbn . '</p>';
echo '<p style="font-size: 20px;">'. 'Copies available: ' . $book->copies . '</p>';


if($book->copies >0){
echo '<form method="post">';
echo '<input type="hidden" name="id" value="'. $bookid . '">';
echo '<input type="submit" name="submitissue" value="Request Issue" class="btn btn-primary" style="font-size: 18px;">';
echo '</form>';
}
else{
    echo '<p style="color: red; font-size: 25px;"><b>Sorry, the book is not available right now</b></p>';

}

echo $OUTPUT->footer();

<?php
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
} 
else {
    echo get_string('nobooks', 'local_library');
}

echo $OUTPUT->footer();

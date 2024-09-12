<?php
require_once('../../config.php');



$id=required_param('id', PARAM_INT);

$DB->delete_records('library_books',['id'=> $id]);



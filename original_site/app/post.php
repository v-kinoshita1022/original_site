<?php
echo var_dump($_POST);
$title = isset($_POST['title']) ? $_POST['title'] : null;
$place = isset($_POST['place']) ? $_POST['place'] : null;
$start_time = isset($_POST['start_time']) ? $_POST['start_time'] : null;
$end_time = isset($_POST['end_time']) ? $_POST['end_time'] : null;
$detail = isset($_POST['detail']) ? $_POST['detail'] : null;
$tags = isset($_POST['tags']) ? $_POST['tags'] : null;
 ?>
 

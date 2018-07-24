<?php
$json_str = file_get_contents('php://input');
$json_obj = json_decode($json_str);
file_put_contents('log0.txt', print_r($_GET, 1), FILE_APPEND);
file_put_contents('log1.txt', print_r($_POST, 1), FILE_APPEND);
file_put_contents('log2.txt', print_r($json_obj, 1), FILE_APPEND);
?>
<?php

require "action.php"; $action = new Action();
require "class_monnify.php"; $monify = new monnify();

$response = file_get_contents('php://input');

file_put_contents("data.txt", $response ." \n", FILE_APPEND);

echo $monify->receivePay($response);
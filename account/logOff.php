<?php
require "../action.php"; $action = new Action();
session_destroy();
$action->redirect_to("../market");
?>
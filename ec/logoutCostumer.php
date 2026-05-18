<?php
require_once 'logic/class/session.php';

$session = new session();
$session->destroy();

header("Location: /sghwebv2/index.php");
exit;
?>
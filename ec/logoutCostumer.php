<?php
require_once 'logic/class/session.php';

$session = new session();
$session->destroy();

header("Location: ../index.php");
exit;
?>
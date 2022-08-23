<?php

$_SESSION = array();

session_destroy();

header("Location: $URL");
exit();
?>
<?php
require_once '../app/helpers/session.php';

session_destroy();
header('Location: index.php');
exit;

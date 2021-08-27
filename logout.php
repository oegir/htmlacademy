<?php
require_once('sess.php');

sess_logout();
header('location: index.php');
die();
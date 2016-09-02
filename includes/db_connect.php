<?php

require_once ($_SERVER['DOCUMENT_ROOT'] . "/listr/includes/psl-config.php");

//$mysqli = new mysqli(HOST, USER, PASSWORD, DATABASE);

$dbh = new PDO('mysql:host=' . HOST . ';dbname=' . DATABASE . '', USER, PASSWORD);


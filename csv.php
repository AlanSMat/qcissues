<?php
session_start();
require("globals.php");
//require(CLASSES_PATH . "/class.DD_text.php");
require(CLASSES_PATH . "/class.ExportCSV.php");

$csv = new ExportCSV(trim(substr($_SESSION["csv_query_string"], 0, strpos($_SESSION["csv_query_string"], "LIMIT"))));

unset($_SESSION["csv_query_string"]);
?>
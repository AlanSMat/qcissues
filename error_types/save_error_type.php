<?php
session_start();
require("../globals.php");

$q = new Query();
$q->save("ert_errortype", "ert_id", $_POST["error_type_id"], $_POST);

header("LOCATION: list_error_types.php?pageid=errorTypes&dep_id=" . $_POST["ert_departmentid"] . "&qcoperator=1");
?>

<?php
include("../globals.php");

$q = new Query("UPDATE opr_operator SET opr_active='0' WHERE opr_id='" . $_REQUEST["operator_id"] . "'");

header("LOCATION: list_operators.php?qcoperator=1");

?>
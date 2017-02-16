<?php
include("../globals.php");

$q = new Query("DELETE FROM ert_errortype WHERE ert_id='" . $_REQUEST["error_type_id"] . "'");

header("LOCATION: list_error_types.php?qcoperator=1");

?>
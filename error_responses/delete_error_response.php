<?php
include("../globals.php");

$q = new Query("DELETE FROM err_errorresponse WHERE opr_id='" .$_REQUEST["error_response_id"] . "'");

header("LOCATION: list_error_responses.php?qcoperator=1");

?>
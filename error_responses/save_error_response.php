<?php
require("../globals.php");

$q = new Query();
$q->save("err_errorresponse", "err_id", $_POST["error_response_id"], $_POST);

header("LOCATION: list_error_responses.php?pageid=errorResponses&qcoperator=1");
?>
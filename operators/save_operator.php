<?php
require("../globals.php");

//** find out whether this is an insert or an update
$q_is_insert = new Query("SELECT * FROM opr_operator WHERE opr_id='" .$_POST["operator_id"]  . "'");
$q_is_insert->num_rows() > 0 ? $insert = 1 : $insert = 0 ;

$_POST["opr_premediacc"] = 1;
$_POST["opr_receivenotifications"] = 1;
$_POST["opr_active"] = 1;

$q_save_operator = new Query();
$operator_id = $q_save_operator->save("opr_operator", "opr_id", $_POST["operator_id"], $_POST);

//** if its an insert - insert values into eccemailccdepartmeoperator bridging table
if($insert) 
{
    $ecc["ecc_operatorid"] = $operator_id;
    
    //** quick and nasty, not nice to be hardcoded like this.
    for ($i = 1; $i < 6; $i++) 
    {
        $ecc["ecc_departmentid"] = $i;
        
        $q_insert = new Query();
        $q_insert->insert_record("ecc_emailccdepartmentoperator", $ecc);
    }
}

header("LOCATION: list_operators.php?pageid=operators&qcoperator=1");
?>
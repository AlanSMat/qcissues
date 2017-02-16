<style type="text/css">
<!--
.style4 {	font-size: 12px;
	font-family: Tahoma;
}
.style5 {font-size: 12px; font-family: Tahoma; font-weight: bold; }
-->
</style>
<span class="style4"><span class="style5">DynamicDropDown -</span> The class is to Fetch values from the DB and display in 3 ListBox.</span>
<?php
/************************************************************************/
/* index.php                                            */
/* =====================================================================*/
/* @Copyright (c) 2005 by Gobinath  (gobinathm at gmail dot com)        */
/*                                                                      */
/* @Author(s): Gobinath                                                 */
/*                                                                      */
/* @Version: 1.0.0                                                      */
/************************************************************************/

/* database configuration */
$dbConfig['type']="mysql";
$dbConfig['server']="localhost";
$dbConfig['username']="root";
$dbConfig['password']="F4xm0d3m";
$dbConfig['database']="ddtest";


include_once("DynamicDropDown.class.php");    //Includes the Class file to this example Script.
$dForm = new DynamicDropDown($dbConfig);      //Creates and Object to the Script
$dFormName = "dform";                         //Assign a NAME for the Form which we will be using in this Example Script
$dForm->DataFetch();                          //Call to the DataFetch method, which will Fetch the data from the Tables.
$dForm->CreateJavaScript($dFormName);         //Call to the CreateJavaScript method,which will dynamically creates the Javascript which loads the Data to the List Box
echo "<form name=\"$dFormName\" method=\"post\">";  //Creates a New form on this Page
$dForm->CreateListBox();                      //Call to the Member Function which will create the Form Object
echo "</form>";                               // Close the Form
$dForm->DynamicDropDown_Close();   //Call to the Destructor type of function
?>
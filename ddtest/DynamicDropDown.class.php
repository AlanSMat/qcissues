<?php
/************************************************************************/
/* DynamicDropDown.class.php                                            */
/* =====================================================================*/
/* @Copyright (c) 2005 by Gobinath  (gobinathm at gmail dot com)        */
/*                                                                      */
/* @Author(s): Gobinath                                                 */
/*                                                                      */
/* @Version: 1.0.0     @Version Date: May 2nd, 2005                     */
/*                                                                      */
/* @Package: DynamicDropDown (Title:  Dynamic Drop Down 3 Level)        */
/* =====================================================================*/
/* @Purpose:                                                            */
/* The class is to Fetch values from the DB and display in 3 ListBox    */
/*                                                                      */
/* @Reason: The 2nd & 3rd DropDown Will be based on the Selection of    */
/*          of the previous listbox value                               */
/************************************************************************/



class DynamicDropDown{

    //Database Connection Variable
    var $db_con;         //Database Connection Variable
    var $rs_con;         //Table Connection Variable

    //Variable to Hold Form Name
    var $FrmObjName;

    //Array Variables, this is the Variable which will Hold the Value fetched from the Tables
    var $arrType;
    var $arrBrand;
    var $arrModel;

    //Sql Variables, Used for storing the SQL Statements
    var $typeSql;
    var $brandSql;
    var $modelSql;

    //Result variables, Used to Store the Result Resource
    var $typeResult;
    var $brandResult;
    var $modelResult;

    //Row Variables
    var $typeRow;
    var $brandRow;
    var $modelRow;

    //Loop Variable
    var $IDx;
    var $IDy;
    var $IDz;


    //Purpose: Constructor of the Function, which will establish the database Connection and Array initialization
    function DynamicDropDown($dbConfig){
        // Connects to the Mysql Server
        $this->db_con=mysql_connect($dbConfig['server'],$dbConfig['username'],$dbConfig['password']) or die(mysql_errno());
        // Select the Database
        $this->rs_con=mysql_select_db($dbConfig['database'],$this->db_con);

        // Array variable initialization
        $this->arrType=array();
        $this->arrBrand=array();
        $this->arrModel=array();


        //Initialization of the Loop Variables
        $this->IDx=0;
        $this->IDy=0;
        $this->IDz=0;
    }

    //Purpose: The Function will act like a Destructor for this Class
    function DynamicDropDown_Close(){   // The function needs to be called manually to close the connection
        mysql_close($this->db_con);   // Closes the Connection with the Database
        unset($this->FrmObjName,$this->arrType,$this->arrBrand,$this->arrModel);   // destroys the specified Variables
        unset($this);   //Destroys the Object created for the Class
    }

    //Purpose; The Function fetches the Data and loads it in the List Box
    function DataFetch(){
        //Suggestions: The Table names can be changed according to the User. But be carefull with the Query and other variables
        // So that the Script will function Properly

        $this->typeSql="select * from type";    //Query to fetch the Data from the table "type"
        $this->typeResult=mysql_query($this->typeSql); //Execute the Query and Store the result in new variable

        // Start fetching the Values from the Result Resource (typeResult)
        while ( $this->typeRow = mysql_fetch_array($this->typeResult,MYSQL_BOTH)){ // TYPE table Fetch While Loop begins Here
            for($i=0;$i<mysql_num_rows($this->typeResult);$i++){
                  $this->arrType[$this->IDx][$i]= $this->typeRow[$i];   // Store the Value of the Type table to the Array
            }

            //create a SQL Query for Fetching the Data from the BRAND Table
            $this->brandSql="select * from `brand` WHERE `type_id`='".$this->typeRow[00]."'";
            $this->brandResult=mysql_query($this->brandSql);  // Execute the Brand Query

            //Start Fetching the Value from the Result resource (brandResult)
            while ($this->brandRow = mysql_fetch_array($this->brandResult,MYSQL_BOTH)){ //BRAND Table Fetch While Loop Begins here
                for($i=0;$i<mysql_num_fields($this->brandResult);$i++){
                    $this->arrBrand[$this->IDy][$i]=$this->brandRow[$i];   // Stores the Brand data to the Array
                }

                //Create a Sql Query for Fetching the Data From the Model Table
                $this->modelSql="select * from model WHERE `brand_id`='".$this->brandRow[0]."'";
                $this->modelResult=mysql_query($this->modelSql);

                //Start Fetching the Value from the Result Resource (ModelResult)
                while($this->modelRow=mysql_fetch_array($this->modelResult,MYSQL_BOTH)){ //MODEL Table Fetch While Loop Starts Here
                    for($i=0;$i<mysql_num_fields($this->modelResult);$i++){
                       $this->arrModel[$this->IDz][$i]=$this->modelRow[$i];   // Store the Value of the Model table to the Array
                    }
                    $this->IDz += 1;
                }//MODEL Table Fetch While Loop Ends Here

                $this->IDy += 1;
            } //BRAND Table Fetch While Loop Ends here

            $this->IDx += 1;
        } // TYPE table Fetch While Loop Ends Here

    }// DataFetch Function Ends here.

    //Purpose: Member Function to Create the Javascript which loading the values in Different Dropdowns
    function CreateJavaScript($frmName){

        $this->FrmObjName=$frmName;  // Assigns the frmName Value to the Global Variable

        //Assign the Form field Elements
        $DocBrandElement = "document.".$this->FrmObjName.".brand";
        $DocModelElement = "document.".$this->FrmObjName.".model";

        // Java Script Generation Starts here
        echo "\r<script type=\"text/javascript\" language=\"javascript\">";
        echo "\r<!--";
        //Create the Java Script for Loading the BRAND LIST BOX
        echo "\rfunction changeBrand(obj){\r";
        for($i=0;$i<count($this->arrType);$i++){
             echo "\rif(obj.value == '".$this->arrType[$i][0]."'){\r";
             echo "\r\t/* Loading Values for the Brand Drop Down */\r";
             echo "\tdocument.$this->FrmObjName.brand.options.length = 0;\r";
             echo "\t$DocBrandElement.options[$DocBrandElement.options.length] = new Option('--Select--','--Select--');\r";
             for($j=0;$j<Count($this->arrBrand);$j++){
                          //Check the Condition and create the Statement to Load Value for the List Boxes
                          if ( $this->arrType[$i][0] == $this->arrBrand[$j][2]){
                               echo "\t$DocBrandElement.options[$DocBrandElement.options.length] = new Option('".$this->arrBrand[$j][1]."','".$this->arrBrand[$j][0]."');\r";
                          }
             }
             echo "\tdocument.$this->FrmObjName.brand.disabled = false;\r";
             echo "\treturn true;\r";
             echo "}\r";
        }
        echo "}\r";
        //Create the Java Script for Loading the MODEL LIST BOX
        echo "\rfunction changeModel(obj){\r";
        for($i=0;$i<count($this->arrBrand);$i++){
             echo "\rif(obj.value == '".$this->arrBrand[$i][0]."'){\r";
             echo "\r\t/* Loading Values for the Brand Drop Down */\r";
             echo "\tdocument.$this->FrmObjName.model.options.length = 0;\r";
             echo "\t$DocModelElement.options[$DocModelElement.options.length] = new Option('--Select--','--Select--');\r";
             for($j=0;$j<count($this->arrModel);$j++){
                          //Check the Condition and create the Statement to Load Value for the List Boxes
                          if ( $this->arrBrand[$i][0] == $this->arrModel[$j][2]){
                               echo "\t$DocModelElement.options[$DocModelElement.options.length] = new Option('".$this->arrModel[$j][1]."','".$this->arrModel[$j][0]."');\r";
                          }
             }
             echo "\tdocument.$this->FrmObjName.model.disabled = false;\r";
             echo "\treturn true;\r";
             echo "}\r";
        }
        echo "}\r";
        echo "-->\r";
        echo "</script>\r";  // Javascript ends here
    }


    //Purpose: Member Function to Create Dynamic List Boxs
    function CreateListBox(){
        //TYPE List Box Creation
         echo "Type <select name=\"type\" size=\"1\" onChange='changeBrand(this)'>\r";
		 echo "<option value='--Select--'>--Select--</option>\r";
   		 //Loads the Data to the Type List Box the one which will have values by default.
         for($i=0;$i<count($this->arrType);$i++){
		         echo "<option value='".$this->arrType[$i][0]."'>".$this->arrType[$i][1]."</option>\r";
  	     }
		 echo "</select> &nbsp; Brand&nbsp;";

         //Brand List Box Creation
         echo "<select name=\"brand\" onChange='changeModel(this)' disabled >\r";  // By Default the Item is Disabled
         echo "<option value='--Select--'>--Select--</option>\r";
	     echo "</select> &nbsp; Model&nbsp;";

         //Model List Box Creation
         echo "<select name=\"model\" disabled>\r";   //By Default the item will be disabled.
         echo "<option value='--Select--'>--Select--</option>\r";
	     echo "</select>\r";
    }
}
?>
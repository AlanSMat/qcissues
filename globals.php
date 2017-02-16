<?php

//define("DOC_ROOT","C:/Program Files/Apache Software Foundation/Apache2.2/htdocs/qcissues");
//define("ROOT_URL","http://localhost/qcissues");
//define("ROOT_FOLDER", "qcissues");
define("SITE_DIR", "qcissues");

define("DOC_ROOT",$_SERVER['DOCUMENT_ROOT'] . '/' . SITE_DIR . "");
define("ROOT_URL","http://" . $_SERVER["SERVER_NAME"] . "/" . SITE_DIR . "");

define("COMPANY",            "News Limited");
define("MAIN_TITLE",         "QC Issues");
define("INCLUDES_PATH",      DOC_ROOT."/assets/server/includes");
define("SERVER_ASSETS_PATH", DOC_ROOT."/assets/server");
define("SCRIPTS_URL",        ROOT_URL . "/assets/client/scripts");
define("IMAGES_URL",         ROOT_URL . "/assets/client/images");
define("ADMIN_URL",          ROOT_URL . "/admin");
define("CLIENT_URL",         ROOT_URL . "/assets/client");
define("CSS_URL",            ROOT_URL . "/assets/client/css");
define("CLASSES_PATH",       SERVER_ASSETS_PATH . "/classes");
define("LIBS_PATH",          SERVER_ASSETS_PATH . "/libs");
define("SITE_URL",           ROOT_URL . "/site");
//define("HANDLERS_PATH",      DOC_ROOT."/assets/server/handlers");

/** Database Access */
define("DATABASE", "qcissues");
define("HOST", "127.0.0.1");

define("USERNAME", "root");
if($_SERVER["SERVER_NAME"] == 'localhost') {
    define("PASSWORD", "");
} else {
    define("PASSWORD", "F4xm0d3m");
}

$conn = new mysqli($_SERVER['SERVER_NAME'], USERNAME, PASSWORD);
include(CLASSES_PATH . "/utilities.php");
include(CLASSES_PATH . "/class.Db.php");
?>
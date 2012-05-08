<?php
$columns = array("id", "name", "short_description", "description", "resources", "base_address", "addresses","contact","group","location","media","e_mail","geo_coordinates","image_or_logo","state","released");
$map = array("id" => 0, "name" => 1, "short_description" => 2, "description" => 3, "resources" => 4, "base_address" => 5, "addresses" => 6,"contact" => 7,"group" => 8,"location" => 9,"media" => 10,"e_mail" => 11,"geo_coordinates" => 12,"image_or_logo" => 13,"state" => 14,"released" => 15);
$columntypes = array("int(11) NOT NULL AUTO_INCREMENT","int(8) NOT NULL", "int(8)", "int(8)", "int(8)", "int(8)", "int(8)", "int(8)", "tinyint(1) DEFAULT NULL", "tinyint(1) DEFAULT NULL", "tinyint(1) DEFAULT NULL", "text", "varchar(10) DEFAULT NULL", "text", "tinyint(1) NOT NULL");
$numColumns = 16;
$langColumns = array(1,2,3,4,5,6,7);
$otherColumns = array(0,8,9,10,11,12,13,14,15);
$booleanColumns = array(8,9,10,15);
$columnList = "";
for ($i = 0; $i < $numColumns; $i++) {
    $columnList .= "`".$columns[$i]."`,";
}
$columnList = substr($columnList,0,strlen($columnList)-1);
$langColumnList = "";
for ($i = 0; $i < count($langColumns); $i++) {
    $langColumnList .= "`".$columns[$langColumns[$i]]."`,";
}
$langColumnList = substr($langColumnList,0,strlen($langColumnList)-1);
?>

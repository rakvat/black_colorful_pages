<?php
include_once("../protected/mysql.inc");
include_once("../commonstuff.php");
$sure = getGet("sure","false");
$id = $_GET['id'];
if (strlen($sure)>0 && $sure=="true") {
    $query = "SELECT ".$langColumnList." FROM `".$tablename."` WHERE `id`='".$id."'";
    $result = mysql_query($query);
    $query = "DELETE FROM `".$tablename."_lang` WHERE ";
    for ($i = 0; $i < count($langColumns); $i++) {
        $query .= "`id`='".mysql_result($result,0,$i)."' OR ";
    }
    $query = substr($query,0,strlen($query) - 4);
    mysql_query($query);
    $query = "DELETE FROM `".$tablename."` WHERE `id`='$id'";
    mysql_query($query);
    header("Location: index.php");
}
$contactLanguage1 = ContactJoinGet("language1",$id);
$contactLanguage2 = ContactJoinGet("language2",$id);
include("top.php");
?>

<h4> Do you really want to delete this structure?</h4>
<table>
<tr><td><b>Language</b></td><td><b><?php echo $l_language_id["language1"]; ?></b> </td><td><b><?php echo $l_language_id["language2"]; ?></b> </td></tr>
<?php
for ($i = 0; $i < count($langColumns); $i++) {
    echo "<tr><td>".$columns[$langColumns[$i]].":</td><td>".$contactLanguage1->m[$langColumns[$i]]."</td><td>".$contactLanguage2->m[$langColumns[$i]]."</td></tr>\n";
}
echo "</table>\n";
for ($i = 1; $i < count($otherColumns); $i++) {
    echo $columns[$otherColumns[$i]].": ".$contactLanguage1->m[$otherColumns[$i]]."<br/>\n";
}
?>



<a href="delete.php?sure=true&id=<?php echo($id); ?>">do it!</a>
</br><a href="index.php">cancel</a><br/>

<?php
include("bottom.php");
?>

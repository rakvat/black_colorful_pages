<?php
include_once("../protected/mysql.inc");
include_once("../commonstuff.php");

$contactLanguage1 = ContactCreateFromPost("language1");
$contactLanguage2 = ContactCreateFromPost("language2");
if (strlen($contactLanguage1->m[$map["name"]]) > 0) {
    $lang_indexes = array();
    for ($i = 0; $i < count($langColumns); $i++) {
        $lang_indexes[$langColumns[$i]] = insertLanguageItemQuery($contactLanguage1->m[$langColumns[$i]], $contactLanguage2->m[$langColumns[$i]]);
    }
    $query = "SELECT MAX(id) FROM `".$tablename."`";
    $result = mysql_query($query);
    $newindex = mysql_result($result, 0, 0) + 1;
    $query = "INSERT INTO `".$tablename."` (".$columnList.") VALUES ('$newindex', ";
    for ($i = 1; $i < count($columns); $i++) {
        if (in_array($i, $langColumns)){
            $query .= "'$lang_indexes[$i]',";
        } else {
            $query .= "'".$contactLanguage1->m[$i]."',";
        }
    }
    $query = substr($query, 0, strlen($query)-1);
    $query .= ")";
    mysql_query($query);
    header("Location: index.php");
}
include("top.php");
?>

<h4> Insert new structure </h4>
<form action="<?php print $_SERVER['PHP_SELF']; ?>" method="post" accept-charset="utf-8">
<table>
<tr><td><b>Language</b></td><td><b><?php echo $l_language_id["language1"]; ?></b> </td><td><b><?php echo $l_language_id["language2"]; ?></b> </td></tr>

<?php
for ($i = 0; $i < count($langColumns); $i++) {
    echo "<tr><td>".$columns[$langColumns[$i]].":</td><td><textarea name=\"".$columns[$langColumns[$i]]."_language1\" rows=\"10\" cols=\"50\"></textarea></td><td><textarea name=\"".$columns[$langColumns[$i]]."_langauge2\" rows=\"10\" cols=\"50\"></textarea></td></tr>\n";
}
echo "</table>\n";
for ($i = 1; $i < count($otherColumns); $i++) {
    if (in_array($otherColumns[$i],$booleanColumns)) {
        echo $columns[$otherColumns[$i]].": <input type=\"checkbox\" value=\"true\" name=\"".$columns[$otherColumns[$i]]."\"><br/>\n";
    } else if ($columns[$otherColumns[$i]] == "state") {
        echo $columns[$otherColumns[$i]].":<textarea name=\"".$columns[$otherColumns[$i]]."\" rows=\"10\" cols=\"50\"></textarea><br/>\n";
    } else {
        echo $columns[$otherColumns[$i]].": <input type=\"text\" value=\"\" name=\"".$columns[$otherColumns[$i]]."\"><br/>\n";
  }
}
?>

<input type="submit" value="insert" />
</form>

</br><a href="index.php">cancel</a><br/>

<?php
include("bottom.php");
?>


<?php
include_once("../protected/mysql.inc");
include_once("../commonstuff.php");
$contactLanguage1 = ContactCreateFromPost("language1");
$contactLanguage2 = ContactCreateFromPost("language2");
$getid = getGet("id","");
if (strlen($getid) > 0) {
    $contactLanguage1 = ContactJoinGet("language1",$getid);
    $contactLanguage2 = ContactJoinGet("language2",$getid);
} else {
    if (strlen($contactLanguage1->m[$map["name"]]) > 0) {
        ContactUpdate($contactLanguage1,$contactLanguage2);
        header("Location: index.php");
    }
}

include("top.php");
?>

<h4> Edit existing structure </h4>

<form action="<?php print $_SERVER['PHP_SELF']; ?>" method="post" accept-charset="utf-8">
<input type="hidden" value="<?php echo($contactLanguage1->m[0]); ?>" name="id">
<table>
<tr><td><b>Language</b></td><td><b><?php echo $l_language_id["language1"]; ?></b> </td><td><b><?php echo $l_language_id["language2"]; ?></b></td></tr>
<?php
for ($i = 0; $i < count($langColumns); $i++) {
    echo "<tr><td>".$columns[$langColumns[$i]].":</td><td><textarea name=\"".$columns[$langColumns[$i]]."_language1\" rows=\"10\" cols=\"50\">".$contactLanguage1->m[$langColumns[$i]]."</textarea></td><td><textarea name=\"".$columns[$langColumns[$i]]."_language2\" rows=\"10\" cols=\"50\">".$contactLanguage2->m[$langColumns[$i]]."</textarea></td></tr>\n";
}
echo "</table>\n";
for ($i = 1; $i < count($otherColumns); $i++) {
    if (in_array($otherColumns[$i],$booleanColumns)) {
        echo $columns[$otherColumns[$i]].": <input type=\"checkbox\" value=\"true\" name=\"".$columns[$otherColumns[$i]]."\" ".checked($contactLanguage1->m[$otherColumns[$i]])."><br/>\n";
    } else if ($columns[$otherColumns[$i]]== "state") {
        echo $columns[$otherColumns[$i]].":<textarea name=\"".$columns[$otherColumns[$i]]."\" rows=\"10\" cols=\"50\">".$contactLanguage1->m[$otherColumns[$i]]."</textarea><br/>\n";
    } else {
        echo $columns[$otherColumns[$i]].": <input type=\"text\" name=\"".$columns[$otherColumns[$i]]."\" value=\"".$contactLanguage1->m[$otherColumns[$i]]."\" ><br/>\n";
    }
}
?>

<input type="submit" value="done" />
</form>

</br><a href="index.php">cancel</a><br/>

<?php
include("bottom.php");
?>

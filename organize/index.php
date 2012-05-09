<?php
include_once("../protected/mysql.inc");
include_once("../commonstuff.php");
echo("start ".microtime_float()."<br/>");
$searchcriteria = OrganizeSearchCriteriaCreateFromPost();
$lang="language1";
include("top.php");
$query = createOrganizeQuery("language1",$searchcriteria->group, $searchcriteria->location, $searchcriteria->media, $searchcriteria->searchterm, $searchcriteria->sortbyrelease, "false");
$result = mysql_query($query);
$num = mysql_numrows($result);
include("form.php");
$starttime = microtime_float();
?>

<a href="insert.php">Insert new structure</a><br/>
<a href="print.php?lang=language1">Printversion <?php echo $l_language_id["language1"]; ?></a><br/>
<a href="print.php?lang=language2">Printversion <?php echo $l_language_id["language2"]; ?></a><br/>

<?php
$i = 0;
echo "<table border='1'>\n";
echo "<tr><td><b>admin</b></td><td><b>lang</b></td><td><b>id</b></td><td><b>Name</b></td><td><b>Short Description</b></td><td><b>Description</b></td><td><b>Ressources</b></td><td><b>Base Address</b></td><td><b>Addresses</b></td><td><b>Contact</b></td><td><b>group</b></td><td><b>location</b></td><td><b>media</b></td><td><b>e-mail</b></td><td><b>geo-coordinates</b></td><td><b>image or logo</b></td><td><b>state</b></td><td><b>released</b></td></tr>\n";
$maillist = "";
$linklist = "";
while($i<$num){
    echo "<tr>\n";
    $contact = ContactFillAll($result, $i);

    $address = " ".$contact->m[$map["addresses"]];
    while (strpos($address,"http://")) {
        $httppos = strpos($address,"http://");
        $httpendpos = strlen($address);
        if (strpos($address," ", $httppos)) {
            $httpendpos = strpos($address," ", $httppos)-1;
        } else if (strpos($address,"\n",$httppos) && strpos($address,"\n",$httppos) < $httpendpos) {
            $httpendpos = strpos($address,"\n",$httppos)-1;
        }
        $link = substr($address,$httppos,$httpendpos-$httppos);
        $linklist = $linklist.$link.", ";
        $address = substr($address, $httpendpos);
    }

    $contact->prepareForHTML();
    $query_language2 = createQueryById("language2",$contact->m[0]);
    $result_language2 = mysql_query($query_language2);
    $contact_language2 = ContactFillAll($result_language2,0);
    $contact_language2->prepareForHTML();

    $id = $contact->m[0];
    echo "<td rowspan=\"2\"><a href=\"edit.php?id=".$id."\">edit</a><br/><a href=\"delete.php?id=".$id."\">delete</a></td>\n";
    $maillist = $maillist.(strlen($contact->m[$map["e_mail"]])>0?$contact->m[$map["e_mail"]].", ":"");
    echo "<td>".$l_language_id["language1"]."</td>";
    for ($j = 0; $j < $numColumns; $j++) {
        echo "<td>".$contact->m[$j]."</td>\n";
    }
    echo "</tr><tr><td>".$l_language_id["language2"]."</td>\n";
    for ($j = 0; $j < $numColumns; $j++) {
        echo "<td>".$contact_language2->m[$j]."</td>\n";
    }
    echo "</tr>\n";
    $i++; 
}
echo "</table>";
echo "<br/><br/>All e-mail addresses of found structures<br/><small>".$maillist."</small>";
echo "<br/><br/>All web pages of found structures (check for broken links)<br/><small>".$linklist."</small>";

echo("<br/><br/><br/>ende ".microtime_float()."<br/>");
echo("duration ".(microtime_float()-$starttime));

include("bottom.php");
?>


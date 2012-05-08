<?php
include_once("protected/mysql.inc");
include_once("commonstuff.php");
$searchcriteria = SearchCriteriaCreateFromPost();
$lang = getGet("lang",getPost("lang","language1"));
include("top.php");

//echo("start ".microtime_float()."<br/>");
//$starttime = microtime_float();

$query = createQuery($lang,$searchcriteria->group, $searchcriteria->location, $searchcriteria->media, $searchcriteria->searchterm, "true");
//echo $query;
$result = mysql_query($query);
//echo "<br/>".mysql_error();

$num = mysql_numrows($result);
include("form.php");

$i = 0;
echo "<div class=\"listarea\">\n";
while($i<$num){
    echo "<div class=\"listelement\">\n";
    $contact = ContactFillAll($result, $i);
    $contact->prepareForHTML();
    echo "<h3 class=\"structuretitle\">".$contact->m[1]."</h3>\n";  //name

    echo "<table class=\"shortlistelement\" width=\"100%\"".($num==1?"style=\"display: none\"":"").">\n";
    echo "<tr><td width=\"61.8%\">".$contact->m[2]."</td>\n";  //kurzbeschreibung
    echo "<td style=\"padding-left: 15px\" >".$contact->m[5]."<br/><br/></td>\n"; //BasisAdresse
    echo "<td align=\"right\"><a class=\"showdetaillink\"><img src=\"TEX/down.png\" alt=\"down\" border=\"0\"/></a></td></tr>\n";
    echo "</table>\n";
    
    echo "<table class=\"longlistelement\" width=\"100%\" ".($num>1?"style=\"display: none\"":"").">\n";
    echo "<tr><td valign=\"top\" width=\"300\">\n";
    if (!empty($contact->m[13])) {
        echo "<img src=\"TEX/".$contact->m[13]."\" alt=\"imgage or logo\" width=\"200\" /><br/><br/>\n";
    }
    echo "<b>".$l_description[$lang].":</b><br/>\n".$contact->m[3]."<br/><br/>\n";
    if (empty($contact->m[13])) {
        echo "<b>".$l_ressources[$lang].":</b><br/>\n".$contact->m[4]."</td>\n"; 
    }
    echo "<td valign=\"top\" width=\"350\" style=\"padding-left: 15px\">";
    if (!empty($contact->m[13])) {
        echo "<b>".$l_ressources[$lang].":</b><br/>\n".$contact->m[4]."<br/><br/>\n"; 
    }
    echo "<b>".$l_addresses[$lang].":</b><br/>".$contact->m[6]."<br/><br/>\n"; //Adresse
    echo "<b>".$l_contact[$lang].":</b><br/>".$contact->m[7]."<br/><br/>\n"; //Kontakt
    echo "</td>\n";
    echo "<td class=\"addstuffhere\" valign=\"top\" align=\"right\" style=\"padding-left: 15px\">\n";
    if (!empty($contact->m[12])) {
        $splitpos = strpos($contact->m[12],";");
        $latitude = substr($contact->m[12],0,$splitpos);
        $longitude = substr($contact->m[12],$splitpos+1); 
        $a = $longitude-0.002;
        $b = $latitude-0.002;
        $c = $longitude+0.002;
        $d = $latitude+0.002;
        if ($num > 1) {
            echo "<b class=\"magic\" bbox=\"".$a.",".$b.",".$c.",".$d."\" marker=\"".$latitude.",".$longitude."\" ></b>";
        } else {
            echo "<iframe width=\"350\" height=\"350\" frameborder=\"0\" scrolling=\"no\" marginheight=\"0\" marginwidth=\"0\" src=\"http://www.openstreetmap.org/export/embed.html?bbox=".$a.",".$b.",".$c.",".$d."&layer=mapnik&marker=".$latitude.",".$longitude."\" style=\"border: 1px solid black\"></iframe>";
            //echo "<image width=\"350\" height=\"350\" src=\"TEX/offline-bsp-map.png\" />";
        }
    }
    echo "</td></tr>\n";
    echo "<tr><td></td><td></td><td align=\"right\"><a class=\"hidedetaillink\"><img src=\"TEX/up.png\" alt=\"up\" border=\"0\" /></a></td></tr></table>\n";

    $i++; 
    if ($i<$num) {
        echo "<hr/>\n";
    }
    echo "</div>\n"; //listelement;
}
echo "</div> <!-- textarea -->";
//echo("<br/>ende ".microtime_float()."<br/>");
//echo("duration ".(microtime_float()-$starttime));
include("bottom.php");
?>


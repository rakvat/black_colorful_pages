<?php
include_once("dbadapter.php");
include_once("locale.php");

////////////////////////////////////////////////////////// CLASS Contact
class Contact {
    var $m = array(); //members

    function prepareForHTML() {
        global $map,$langColumns;
        for ($i = 0; $i < count($langColumns); $i++) {
            $id = $langColumns[$i];
            $this->m[$id] = str_replace("\n","<br/>",htmlentities($this->m[$id]));
        }
        $this->m[$map["addresses"]] = preg_replace("/(http:\/\/\S*)/i","<a href=\"$1\" target=\"_blank\">$1</a>",$this->m[$map["addresses"]]);
        $this->m[$map["contact"]] = str_replace("@"," -at- ",$this->m[$map["contact"]]);
    }

    function setAttributesToFallback($default) {
        global $langColumns;
        for ($i = 0; $i < count($langColumns); $i++) {
            $id = $langColumns[$i];
            $this->m[$id] = fallback($this->m[$id], $default->m[$id]);
        }
    }

    function getValueList() {
        global $numColumns;
        $valueList = "";
        for ($i = 0; $i < $numColumns; $i++) {
            $valueList = $valueList."\"".$m[$i]."\",";
        }
        return substr($valueList,0,strlen($valueList)-1);
    }

    function getKeyValueList() {
        global $numColumns,$columns;
        $keyValueList = "";
        for ($i = 0; $i < $numColumns; $i++) {
            $keyValueList = $keyValueList."`".$columns[$i]."`=\"".$m[$i]."\",";
        }
        return substr($keyValueList,0,strlen($keyValueList)-1);
    }

    function insert($lang) {
        global $dbname, $columnList;
        $query = "INSERT INTO `".$dbname."_".$lang."` (".$columnList.") VALUES (".getValueList().")";
        mysql_query($query);
    }
    
    function update($lang) {
        global $dbname;
        $query = "UPDATE `".$dbname."_".$lang."` ".getKeyValueList();
        mysql_query($query);
    }
}

function ContactUpdate($contact_language1, $contact_language2) {
    global $dbname, $langColumnList, $langColumns, $otherColumns, $columns;
    $query = "SELECT ".$langColumnList." FROM `".$dbname."` WHERE `id`='".$contact_language1->m[0]."'";
    $result = mysql_query($query);
    for ($i = 0; $i < count($langColumns); $i++) {
        if (empty($contact_language2->m[$langColumns[$i]])) {
            $contact_language2->m[$langColumns[$i]] = $contact_language1->m[$langColumns[$i]];
        }
        mysql_query("UPDATE `".$dbname."_lang` SET `language1`=\"".$contact_language1->m[$langColumns[$i]]."\", `language2`=\"".$contact_language2->m[$langColumns[$i]]."\" WHERE `id`='".mysql_result($result,0,$i)."'");
    }
    $query = "UPDATE `".$dbname."` SET ";
    for ($i = 1; $i < count($otherColumns); $i++) {
        $query .= "`".$columns[$otherColumns[$i]]."`='".$contact_language1->m[$otherColumns[$i]]."',";
    }
    $query = substr($query,0,strlen($query)-1);
    $query .= " WHERE `id`='".$contact_language1->m[0]."'";
    mysql_query($query);
}

function ContactFillSome($result, $i) {
    $contact = new Contact();
    global $langColumns, $columns;

    $contact->m[0] = mysql_result($result, $i, 0);
    for ($j = 0; $j < count($langColumns); $j++) {
        $contact->m[$langColumns[$j]] = mysql_result($result, $i, $columns[$langColumns[$j]]);
    }
    return $contact;
}

function ContactFillAll($result, $i) {
    global $columns, $otherColumns;
    $contact = ContactFillSome($result, $i);
    for ($j = 1; $j < count($otherColumns); $j++) {
        $contact->m[$otherColumns[$j]] = mysql_result($result, $i, $columns[$otherColumns[$j]]);
    }
    return $contact;
}

function ContactCreateFromPost($lang) {
    global $langColumns, $otherColumns, $columns, $booleanColumns;
    $contact = new Contact();
    for ($i = 0; $i < count($langColumns); $i++) {
        $contact->m[$langColumns[$i]] = prepareForSql(getPost($columns[$langColumns[$i]]."_".$lang,""));
    }
    for ($i = 0; $i < count($otherColumns); $i++) {
        if (in_array($otherColumns[$i],$booleanColumns)) {
            $contact->m[$otherColumns[$i]] = getSQLBool(getPost($columns[$otherColumns[$i]], "false"));
        } else {
            $contact->m[$otherColumns[$i]] = prepareForSql(getPost($columns[$otherColumns[$i]], ""));
        }
    }
    return $contact;
}

function ContactGet($lang, $id) {
    global $dbname;
    $result = mysql_query("SELECT * FROM `".$dbname."_".$lang."` WHERE `id`='$id'");
    return ContactFillAll($result,0);
}

function ContactJoinGet($lang, $id) {
    $result = mysql_query(createJoinQuery($lang)." WHERE Main.id='".$id."'");
    return ContactFillAll($result,0);

}    

///////////////////////////////////////////////////////////////////CLASS SUCHKRITERIEN
class SearchCriteria {
    var $group, $media, $location, $searchterm;
}

function SearchCriteriaCreateFromPost() {
    $searchCriteria = new SearchCriteria();
    $searchCriteria->group = getPost("group","false");
    $searchCriteria->location = getPost("location","false");
    $searchCriteria->media = getPost("media","false");
    $searchCriteria->searchterm = getGet("searchterm",getPost("searchterm",""));
    return $searchCriteria;
} 

class OrganizeSearchCriteria {
    var $group, $media, $location, $searchterm, $sortbyrelease;
}

function OrganizeSearchCriteriaCreateFromPost() {
    $searchCriteria = new OrganizeSearchCriteria();
    $searchCriteria->group = getPost("group","false");
    $searchCriteria->location = getPost("location","false");
    $searchCriteria->media = getPost("media","false");
    $searchCriteria->searchterm = getGet("searchterm",getPost("searchterm",""));
    $searchCriteria->sortbyrelease = getPost("sortbyrelease","false");
    return $searchCriteria;
} 
//////////////////////////////////////////////////////// SMALL HELPER
function getPost($theKey, $theDefault) {
    return (empty($_POST[$theKey])?$theDefault:$_POST[$theKey]);
}

function getGet($theKey, $theDefault) {
    return (empty($_GET[$theKey])?$theDefault:$_GET[$theKey]);
}

function checked($theFlag) {
    if($theFlag=="true" || $theFlag=="1") {
        return "checked=\"checked\"";
    }
    return "";
}

function getSQLBool($theBool) {
    return($theBool == "true"?"1":"0");
}

function getTextBool($theBool) {
    return($theBool == "1"?"true":"false");
}

function fallback($value, $default) {
    return((!isset($value)||strlen($value) == 0)?$default:$value); 
}

function utf2latin($text) {
   $text=htmlentities($text,ENT_COMPAT,'UTF-8');
   return html_entity_decode($text,ENT_COMPAT,'ISO-8859-1');
} 

function prepareForSql($text) {
    //$text=utf8_encode($text);
    //$text=utf2latin($text);
    $text=utf8_decode($text);
    $text=str_replace("\"","\\\"",$text);
    return $text;
}

//////////////////////////////////////////////////// QUERIES
function insertLanguageItemQuery($language1, $language2) {
    global $dbname;
    $query = "SELECT MAX(id) FROM `".$dbname."_lang`";
    $result = mysql_query($query);
    $newindex = mysql_result($result,0,0) + 1;
    if (empty($language2)) {
        $language2 = $language1;
    }
    $query = "INSERT INTO `".$dbname."_lang` (`id`, `language1`, `language2`) VALUES ('$newindex', \"$language1\", \"$language2\")";
    mysql_query($query);
    return $newindex;
}

function createJoinQuery($lang) {
    global $dbname, $columns, $langColumns, $otherColumns;
    $query = "SELECT Main.id, ";
    $joinpart = "";
    for ($i = 0; $i < count($langColumns); $i++) {
        $name = $columns[$langColumns[$i]];
        $query = $query."L".$name.".".$lang." AS ".$name.",";
        $joinpart = $joinpart."JOIN `".$dbname."_lang` `L".$name."` ON L".$name.".id = `".$name."`\n";
    }
    for ($i = 1; $i < count($otherColumns); $i++) {
        $query = $query."`".$columns[$otherColumns[$i]]."`,";
    }
    $query = substr($query,0,strlen($query)-1)."\nFROM `".$dbname."` `Main`\n".$joinpart;
    return $query;
}


//ToDo: refactor
function createBasicQuery($lang, $group, $location, $media, $searchterm, $released) {
    $query = createJoinQuery($lang);
    $where = " WHERE ";
    if ($released=="true") {
        $where = $where."`released`=1";
    }
    if ($group=="true") {
        $where = $where."`group`=1";
    }
    if ($location=="true") {
        $where = $where.(strlen($where)>7?" AND ":"")."`location`=1";
    }
    if ($media=="true") {
        $where = $where.(strlen($where)>7?" AND ":"")."`media`=1";
    }
    if (strlen($searchterm) > 0) {
        $like = " LIKE \"%".$searchterm."%\"";
        $where = $where.(strlen($where)>7?" AND ":"")."(a_name.".$lang.$like." OR a_description.".$lang.$like." OR a_short_descrition.".$lang.$like." OR a_resources.".$lang.$like." OR a_addresses.".$lang.$like." OR a_contact.".$lang.$like.")";
    }
    $query = $query.(strlen($where)>7?$where:"");
    return $query;
}

function createQuery($lang, $group, $location, $media, $searchterm, $released) {
    $query = createBasicQuery($lang, $group, $location, $media, $searchterm, $released);
    $query = $query." ORDER BY `name`";

    //does not work for php4(?)
    //$query = iconv("UTF-8", "Latin1", $query);
    $query = utf2latin($query);
    return $query;
}

function createOrganizeQuery($lang, $group, $location, $media, $searchterm, $sortbyrelease, $released) {
    $query = createBasicQuery($lang, $group, $location, $media, $searchterm, $released);
    if ($sortbyrelease=="true") {
        $query = $query." ORDER BY `released`, `name`";
    }  else {
        $query = $query." ORDER BY `name`";
    }

    //does not work for php4(?)
    //$query = iconv("UTF-8", "Latin1", $query);
    $query = utf2latin($query);
    return $query;
}

function createQueryById($lang, $id) {
    $query = createJoinQuery($lang);
    $query .= " WHERE Main.id = '".$id."'";
    return $query;
}

function createOriginalTable () {
    createTableForLanguage("");
}

function createTableForLanguage($lang) {
    global $dbname,$columns,$columntypes;
    if (strlen($lang) > 0) {
        $lang = "_".$lang;
    }
    $query = "DROP TABLE `".$dbname.$lang."`";
    mysql_query($query);
    $query = "CREATE TABLE `".$dbname.$lang."` (";
    for ($i = 0; $i < count($columns); $i++) {
        $query = $query."`".$columns[$i]."` ".$columntypes[$i].",\n";
    }
    $query = $query."PRIMARY KEY (`id`))";
    mysql_query($query);
}

function createLanguageTable() {
    global $dbname;
    $query="DROP TABLE `".$dbname."_lang`";
    mysql_query($query);
    $query="CREATE TABLE `".$dbname."_lang` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `language1` text NOT NULL,
    `language2` text NOT NULL,
    PRIMARY KEY (`id`)
    )";
    mysql_query($query);
}


/////////////////////////////////////////////////////////////// Unrelated GOOD PARTS
function microtime_float() {
    list($usec, $sec) = explode(" ", microtime());
    return ((float)$usec + (float)$sec);
}

?>

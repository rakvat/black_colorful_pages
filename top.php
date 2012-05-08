<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
        "http://www.w3.org/TR/html4/loose.dtd">

<html>
<head>

<meta http-equiv="Content-Type" content="text/html;charset=utf-8" >
<meta name="Title" content=<?php echo $l_title[$lang]; ?>>
<meta name="Author" content=<?php echo $l_author[$lang]; ?>>
<meta name="Description" content=<?php echo $l_html_description[$lang]; ?>>
<meta name="Revisit" content="After 15 days">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="Keywords" content=<?php echo $l_html_keywords[$lang]; ?>>
<meta name="Robots" content="INDEX,FOLLOW">
<meta name="content-language" content=<?php echo $default_language; ?>>
<link rel="shortcut icon" href="contacts.ico">
<link rel="stylesheet" type="text/css" href="contacts.css">
<script type="text/javascript" src="http://code.jquery.com/jquery-1.7.2.min.js"></script>
<script type="text/javascript">                                         
$(document).ready(function() {
  $("a[class=showdetaillink]").click(function() {
      var myLongTable = $(this).parents("div[class=listelement]").find("table[class=longlistelement]");
      myLongTable.stop().show();//animate({height: 'show'}, 'slow');
      var myMagicP = myLongTable.find("b[class=magic]");
      var myBBox = myMagicP.attr("bbox");
      if (myBBox != null && myLongTable.find("iframe").attr("src") == null) {
          var myAddStuffHere = myLongTable.find("td[class=addstuffhere]");
          var myMarker = myMagicP.attr("marker");
          var myIFrame = "<iframe width=\"350\" height=\"350\" frameborder=\"0\" scrolling=\"no\" marginheight=\"0\" marginwidth=\"0\" src=\"http://www.openstreetmap.org/export/embed.html?bbox="+myBBox+"&layer=mapnik&marker="+myMarker+"style=\"border: 1px solid black\"></iframe>";
          //var myIFrame = "<image width=\"350\" height=\"350\" src=\"TEX/offline-bsp-map.png\" />";
         myAddStuffHere.append(myIFrame); 
      }
      var myShortTable = $(this).parents("table");
      //myShortTable.css({'z-index' : '0'});
      myShortTable.stop().hide();//animate({height: 'hide'},'slow');  
  });
  $("a[class=hidedetaillink]").click(function() {
      var myShortTable = $(this).parents("div[class=listelement]").find("table[class=shortlistelement]");
      //myShortTable.css({'z-index' : '10'});
      var myLongTable = $(this).parents("table");
      //myLongTable.css({'z-index' : '0'});
      myLongTable.stop().hide();//animate({height: 'hide', opacity: 'hide'}, 'slow');
      myShortTable.stop().show();//animate({height: 'show', opacity: 'show'}, 'slow');
  });
});
</script> 
<title><?php echo $l_title[$lang]; ?></title>
</head>

<body text="#000000" bgcolor="#FFFFFF" onLoad="if (self != top) top.location = self.location">

<a name="top"></a>
<center>
<div class="container">


<!--title-->
<div class="header">
<a href=<?php echo "index.php?lang=".$lang; ?> border="0" class="none">
<img src="TEX/header.png" border="0" alt="header"/>
</a>
</div>


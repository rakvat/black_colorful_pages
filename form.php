<!-- toolbar -->
<div class="toolbar">
<table width="100%" border="0">
<tr>
<?php
$actionlink = $_SERVER['PHP_SELF'];
if (!strpos($actionlink,"organize")) {
    $actionlink="list.php";
}
?>
<form action="<?php echo $actionlink; ?>" method="post">
  <input type="hidden" value="<?php echo($lang); ?>" name="lang">
  <td>    <?php echo $l_group[$lang];?>: <input type="checkbox" value="true" <?php checked($search_criteria->group);?> name="group"></td>
  <td>    <?php echo $l_location[$lang];?>: <input type="checkbox" value="true" <?php checked($search_criteria->location); ?> name="location"></td>
  <td>    <?php echo $l_media[$lang];?>: <input type="checkbox" value="true" <?php checked($search_criteria->media); ?> name="media"></td>
  <td>    <?php echo $l_searchterm[$lang];?>: <input type="text" value="<?php print($search_criteria->searchterm); ?>" name="searchterm"> </td>
  <td>    <input type="submit" value=<?php echo $l_search[$lang]; ?> /></td>
</form>
<td><a href=<?php echo $actionlink; ?> class="toolbarlink"><?php echo $l_reset[$lang]; ?></a></td>
<td><?php echo $num." ".($num>1?$l_structures[$lang]:$l_structure[$lang]); ?> </td>
<td><a href="index.php?lang=language1" class="toolbarlink"><?php echo $l_language_id["language1"]; ?></a> | <a href="index.php?lang=language2" class="toolbarlink"><?php echo $l_language_id["language2"]; ?></a></td>
</tr></table>
</div>

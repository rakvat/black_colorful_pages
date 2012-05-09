<!-- toolbar -->
<div class="toolbar">
<table width="100%" border="0">
<?php
$actionlink = $_SERVER['PHP_SELF'];
if (!strpos($actionlink,"organize")) {
    $actionlink="list.php";
}
?>
<form action="<?php echo $actionlink; ?>" method="post">
  <input type="hidden" value="<?php echo($lang); ?>" name="lang">
<tr>
  <td>    <?php echo $l_group[$lang];?>: <input type="checkbox" value="true" <?php checked($searchcriteria->group);?> name="group"></td>
  <td>    <?php echo $l_location[$lang];?>: <input type="checkbox" value="true" <?php checked($searchcriteria->location); ?> name="location"></td>
  <td>    <?php echo $l_media[$lang];?>: <input type="checkbox" value="true" <?php checked($searchcriteria->media); ?> name="media"></td>
  <td>    <?php echo $l_searchterm[$lang];?>: <input type="text" value="<?php print($searchcriteria->searchterm); ?>" name="searchterm"> </td>
</tr>
<tr>
  <td>   <?php echo "order by 'released'?"?><input type="checkbox" value="true" <?php checked($searchcriteria->sortbyrelease);?> name="sortbyrelease" ></td>
  <td>    <input type="submit" value=<?php echo $l_search[$lang]; ?> /></td>
</form>
<td><a href=<?php echo $actionlink; ?> class="toolbarlink"><?php echo $l_reset[$lang]; ?></a></td>
<td><?php echo $num." ".($num>1?$l_structures[$lang]:$l_structure[$lang]); ?> </td>
<td></td>
</tr></table>
</div>

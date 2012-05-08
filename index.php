<?php
include("commonstuff.php");
$lang = getGet("lang","language1");
include("top.php");
?>

<div class="listarea">
<?php echo $l_index_header[$lang]; ?>
<a href=<?php echo "list.php?lang=".$lang ?>><?php echo $l_enter[$lang]; ?></a>
<?php echo $l_index[$lang]; ?>
<a href=<?php echo "list.php?lang=".$lang ?>><?php echo $l_enter[$lang]; ?></a>
<br/><br/><br/>

</div> <!-- textarea-->
<?php
include("bottom.php");
?>

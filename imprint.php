<?php
$lang = $_GET['lang'];
include("locale.php");
include("top.php");
?>

<div class="listarea">
<?php echo $l_impressum[$lang]; ?>
<img src="TEX/imprint.png" alt="imprint" />
</div> <!-- textarea-->
<?php
include("bottom.php");
?>


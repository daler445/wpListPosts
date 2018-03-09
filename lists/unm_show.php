<?php
	$id = $_GET["id"];
	if ($id == null) {
		echo "<h5>ID IS NULL</h5>";
	} else {
		echo "<h5>ID: $id</h5>";
		print_r(osimp_get_list($id));
	}
?>
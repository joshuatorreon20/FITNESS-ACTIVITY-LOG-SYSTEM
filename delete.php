<?php
include 'db.php';

$id = (int)$_GET['id'];
mysqli_query($conn, "DELETE FROM activities WHERE id = $id");

header("Location: index.php?msg=deleted");
exit();
?>

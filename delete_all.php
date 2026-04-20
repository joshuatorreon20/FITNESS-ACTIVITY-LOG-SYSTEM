<?php
include 'db.php';

mysqli_query($conn, "DELETE FROM activities");

header("Location: index.php?msg=cleared");
exit();
?>
Write
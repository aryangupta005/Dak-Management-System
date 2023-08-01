<?php
include("includes/dbconnect.php");
$catid = $_GET['catid'];
 $query="select * from project where cat_id = $catid ; ";
 $result = mysqli_query($conn, $query);
 while ($row = mysqli_fetch_assoc($result))
 {
 echo"<option value =".$row['id']."> ".$row['proj_name']."</option>";
 }
?>
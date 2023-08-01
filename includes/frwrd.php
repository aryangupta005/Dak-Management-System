<?php
include 'dbconnect.php';
session_start();
$empid=$_POST['empid'];
$fid=$_GET['fileid'];
$ftid = $_GET['ftid'];
$find="'";
$replace="''";
$remarks1=str_replace($find,$replace,$_POST['remarks1']);
$remarks2=str_replace($find,$replace,$_POST['remarks2']);
date_default_timezone_set("Asia/Kolkata");
$timestamp1 = date('Y-m-d H:i:s');
if( isset($_POST['mark_to']) )
{
/*$sql = " select * from employee where role_id = $roleid ; " ;
$result = mysqli_query($conn , $sql);
while($row = mysqli_fetch_array($result))
extract($row);*/
$sql1 ="INSERT INTO `file_track` (`f_id`, `sender_id`, `receiver_id`, `ft_remarks`,
sender_timestamp)
VALUES ( $fid, ".$_SESSION['userid']." ,'$empid' , '$remarks1', '$timestamp1'); ";
echo $sql1;
$result1 = mysqli_query($conn, $sql1);
if($result1)
{ $_SESSION['showAlert']=true;
echo "True"; }
else
{ $_SESSION['showError']=true;
echo "False"; }
$sql3 = "SELECT * FROM `file_track` where ft_id = $ftid ;";
$result3 = mysqli_query($conn, $sql3);
while($row3=mysqli_fetch_array($result3))
extract($row3);
$receiver_timestamp;
$sql4= " update file_track set ft_action = 1, date_diff =
DATEDIFF(CURRENT_TIMESTAMP,'$receiver_timestamp') where ft_id = $ftid ; " ;
echo $sql4;
$result4 = mysqli_query($conn, $sql4);
header ("location:../inbox.php");
}
if(isset($_POST['filenum_update']))
{
$sql2="update files set file_num = '".$_POST['filenum']."' where f_id = $fid ;";
$result2 = mysqli_query($conn, $sql2);
header ("location:../view.php?ftid=".$ftid."&fileid=".$fid."&page=".$_GET['page']."");
}
if(isset($_POST['closefile']))
{
$sql5 = " select * from employee where role_id = 23 ";
$result5 = mysqli_query($conn , $sql5);
while($row5 = mysqli_fetch_array($result5))
extract($row5);
$e_id;
$sql6 = " update files set f_status = 2 where f_id = $fid ";
$result6 = mysqli_query($conn , $sql6);
$sql1 ="INSERT INTO `file_track` (`f_id`, `sender_id`, `receiver_id`, `ft_remarks`, sender_timestamp) VALUES ( $fid, ".$_SESSION['userid']." ,'$e_id' , '$remarks2', '$timestamp1'); ";
echo $sql1;
$result1 = mysqli_query($conn, $sql1);
if($result1)
{ $_SESSION['showAlert']=true;
echo "True"; }
else
{ $_SESSION['showError']=true;
echo "False"; }
$sql3 = "SELECT * FROM `file_track` where ft_id = $ftid ;";
$result3 = mysqli_query($conn, $sql3);
while($row3=mysqli_fetch_array($result3))
extract($row3);
$receiver_timestamp;
$sql4= " update file_track set ft_action = 1, date_diff =
DATEDIFF(CURRENT_TIMESTAMP,'$receiver_timestamp') where ft_id = $ftid ; " ;
echo $sql4;
$result4 = mysqli_query($conn, $sql4);
header ("location:../inbox.php");
}
?>
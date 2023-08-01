<?php
include 'dbconnect.php';
session_start();
//$user_name = $_POST["user_name"];
//$desig = $_POST["desig"];
$eid = $_SESSION['userid'];
$file_name =$_POST["file_name"];
$fid = $_POST['fid'];
$description= $_POST["description"];
$cat_id=$_POST["cat_id"];
$proj_id=$_POST["proj_id"];
$port_id= $_POST["port_id"];
$bid_id= $_POST["bid_id"];
$quantity= $_POST["quantity"];
$total_cost= $_POST["total_cost"];
$remark= $_POST["remark"];
$fin_id=$_POST["fin_id"];
$docket_no=$_POST["docket_no"];
date_default_timezone_set("Asia/Kolkata");
$timestamp1 = date('Y-m-d H:i:s');
//update button
if(isset($_POST["update"]))
{
$sql= "UPDATE `files` SET
`file_name` = '$file_name',
`docket_no` = '$docket_no',
`description` = '$description',
`quantity` = '$quantity',
`total_cost` = '$total_cost',
`cat_id` = '$cat_id',
`proj_id` = '$proj_id',
`port_id` = '$port_id',
`bid_id` = '$bid_id',
`fin_id` = '$fin_id',
`f_remark` = '$remark'
WHERE `f_id` = '$fid' ; ";
echo $sql;
$result = mysqli_query($conn, $sql);
if($result)
{ $_SESSION['showAlert']=true;
echo "True"; }
else
{ $_SESSION['showError']=true;
echo "False"; }
}
//mark to ad button
if(isset($_POST["mark_ad"]))
{
$sql1= "UPDATE `files` SET
`file_name` = '$file_name',
`docket_no` = '$docket_no',
`description` = '$description',
`quantity` = '$quantity',
`total_cost` = '$total_cost',
`cat_id` = '$cat_id',
`proj_id` = '$proj_id',
`port_id` = '$port_id',
`bid_id` = '$bid_id',
`fin_id` = '$fin_id',
`f_remark` = '$remark',
`f_status` = 1,
`mark_to_ad` = '$timestamp1'
WHERE `f_id` = '$fid' ; ";
echo $sql1;
$result1 = mysqli_query($conn, $sql1);
$sql2="SELECT * FROM `e_group` where id = ".$_SESSION['groupid']." ; ";
echo $sql2;
$result2 = mysqli_query($conn, $sql2);
while($rows2=mysqli_fetch_array($result2))
extract($rows2);
if($ad_id == 0 )
{$recv_id = $gh_id;}
else
{$recv_id = $ad_id;}
$sql3 ="INSERT INTO `file_track` ( `f_id`, `sender_id`, `receiver_id`, `ft_remarks`, sender_timestamp)  VALUES ( $fid, ".$_SESSION['userid']." ,'$recv_id' , '$remark', '$timestamp1'); ";
echo $sql3;
$result3 = mysqli_query($conn, $sql3);
if($result3)
{ $_SESSION['showAlert']=true;
echo "True"; }
else
{ $_SESSION['showError']=true;
echo "False"; }
}
//mark to su button
if(isset($_POST["mark_su"]))
{
$sql1= "UPDATE `files` SET
`file_name` = '$file_name',
`docket_no` = '$docket_no',
`description` = '$description',
`quantity` = '$quantity',
`total_cost` = '$total_cost',
`cat_id` = '$cat_id',
`proj_id` = '$proj_id',
`port_id` = '$port_id',
`bid_id` = '$bid_id',
`fin_id` = '$fin_id',
`f_remark` = '$remark',
`f_status` = 1,
`mark_to_ad` = '$timestamp1'
WHERE `f_id` = '$fid' ; ";
echo $sql1;
$result1 = mysqli_query($conn, $sql1);
$sql2="SELECT * FROM employee left join role on employee.role_id = role.id where role.short_name = 'SU' ; ";
echo $sql2;
$result2 = mysqli_query($conn, $sql2);
while($rows2=mysqli_fetch_array($result2))
extract($rows2);
$e_id;
$sql3 ="INSERT INTO `file_track` ( `f_id`, `sender_id`, `receiver_id`, `ft_remarks`, sender_timestamp)  VALUES ( $fid, ".$_SESSION['userid']." ,'$e_id' , '$remark', '$timestamp1'); ";
echo $sql3;
$result3 = mysqli_query($conn, $sql3);
if($result3)
{ $_SESSION['showAlert']=true;
echo "True"; }
else
{ $_SESSION['showError']=true;
echo "False"; }
}
// mark to mmg button
if(isset($_POST["mark_mmg"]))
{
$sql1= "UPDATE `files` SET
`file_name` = '$file_name',
`docket_no` = '$docket_no',
`description` = '$description',
`quantity` = '$quantity',
`total_cost` = '$total_cost',
`cat_id` = '$cat_id',
`proj_id` = '$proj_id',
`port_id` = '$port_id',
`bid_id` = '$bid_id',
`fin_id` = '$fin_id',
`f_remark` = '$remark',
`f_status` = 1,
`mark_to_ad` = '$timestamp1'
WHERE `f_id` = '$fid' ; ";
echo $sql1;
$result1 = mysqli_query($conn, $sql1);
$sql2="SELECT * FROM employee left join role on employee.role_id = role.id where role.short_name = 'DISP_MMG' ";
echo $sql2;
$result2 = mysqli_query($conn, $sql2);
while($rows2=mysqli_fetch_array($result2))
extract($rows2);
$e_id;
/*if($ad_id == 0 )
{$recv_id = $gh_id;}
else
{$recv_id = $ad_id;}
*/
$sql3 ="INSERT INTO `file_track` ( `f_id`, `sender_id`, `receiver_id`, `ft_remarks`, sender_timestamp)
 VALUES ( $fid, ".$_SESSION['userid']." ,'$e_id' , '$remark', '$timestamp1'); ";
echo $sql3;
$result3 = mysqli_query($conn, $sql3);
if($result3)
{ $_SESSION['showAlert']=true;
echo "True"; }
else
{ $_SESSION['showError']=true;
echo "False"; }
}
header ("location:../draft.php");
?>
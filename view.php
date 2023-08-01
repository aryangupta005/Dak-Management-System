<?php
 include 'includes/dbconnect.php';
session_start();
if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin']!=true){
 header("location: login.php");
 exit;
}
$id = $_GET['fileid'];
?>
<html>
 <head>
 <!-- Required meta tags -->
 <meta charset="utf-8">
 <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
 <!-- Bootstrap CSS -->
 <link rel="stylesheet" href="includes/style.css" >
<link rel="stylesheet" href="includes/style2.css" >
<title>FTS | View File</title>
</head>
<body class='view-bg'>
 <?php include 'includes/header.php';
 include 'includes/nav.php'; ?>
<div>
<form action="includes/frwd.php?ftid=<?php echo $_GET['ftid']."&fileid=".$_GET['fileid']."&page=".$_GET['page']; ?>" method="post">
<p>&nbsp;</p>
<p align="center" class="font36"><img src="image/fileinfo2.png" alt="DA" width="80" height="80">
FILE INFORMATION
<img src="image/fileinfo2.png" width="80" height="80"></p>
<p>&nbsp;</p>
<p align="center">
 <?php
$sql1="SELECT files.*, initr.name as initiator_name, initr.group_id, e_group.g_name as initrgroup , e_group.ad_id,
e_group.gh_id, desig.name as designame, project.proj_name, category.cat_name, bidding_mode.bid_mode,
financial_year.fin_year, portal.portal_name FROM (( ( ( ( ( ( ( files left JOIN employee as initr ON files.e_id = initr.e_id ) left JOIN desig ON initr.desig_id = desig.id ) left JOIN project ON files.proj_id = project.id ) left join category on
files.cat_id = category.id) left join bidding_mode on files.bid_id = bidding_mode.id) left join financial_year on files.fin_id = financial_year.id) left join portal on files.port_id = portal.id) LEFT JOIN e_group ON initr.group_id = e_group.id) where f_id='$id'";
 $result1 = mysqli_query($conn, $sql1);
while($row1= mysqli_fetch_array($result1))
extract($row1);
$group_id;
if($ad_id == 0)
{$emphead = $gh_id;}
else
{$emphead = $ad_id;}
?>
<table class="table2">
 <tr>
 <td class="finfo">DOCKET NUMBER</td>
<td> <?php echo $docket_no; ?> </td></tr>
 <tr>

 <tr>
<td class="finfo">FILE NUMBER</td>
<td> <?php
if($file_num == "" and $_SESSION['rolename']== "HMMG" && $_GET['page'] == "inbox")
{ ?><input style="height: 35px; padding:8px 12px; width:300px" name="filenum" type="text">
&nbsp;&nbsp; <input class="ini-button" type="submit" name="filenum_update" value="Update"> <?php }
else
{ if ($file_num == "" ) echo " TO BE FILLED BY HEAD MMG "; else echo $file_num ; } ?>
</td></tr>
 <tr>

 <tr>
 <td class="finfo">CATEGORY</td>
 <td> <?php echo $cat_name ; ?> </td>
</tr>
 <tr>
 <td class="finfo">PROJECT NAME/NO.</td>
 <td> <?php echo $proj_name ; ?></td>
 </tr>

 <tr>
 <td class="finfo">Portal</td>
 <td> <?php echo $portal_name ; ?></td>
 </tr>

 <tr>
 <td class="finfo">BIDDING MODE</td>
 <td> <?php echo $bid_mode ; ?> </td>
</tr>
 <tr>
 <td class="finfo">FILE NAME</td>
 <td> <?php echo $file_name ; ?></td>
 </tr>

 <tr>
 <td class="finfo">FILE INITIATOR NAME AND DESIGNSTION</td>
 <td> <?php echo $initiator_name.' , '. $designame.' , '.$initrgroup ; ?></td>
 </tr>

 <tr>
 <td class="finfo"> DESCRIPTION</td>
 <td> <?php echo $description ; ?></td>
 </tr>

 <tr>
 <td class="finfo">QUANTITY</td>
 <td> <?php echo $quantity ; ?></td>
</tr>
<tr>
 <td class="finfo">COST</td>
 <td> <?php echo $total_cost ; ?> </td>
</tr>
<tr>
 <td class="finfo">FINANCIAL YEAR</td>
 <td><?php echo $fin_year ; ?> </td>
 </tr>
 <tr>
 <td class="finfo">FILE STATUS</td>
 <td><?php if($f_status ==1) echo "Processing"; elseif($f_status ==2) echo "Closed"; ?> </td>
 </tr>
 </table>
 <!--</form>-->
 &emsp;
<p align="center" class="font36"><img src="image/filetrack2.png" alt="DA" width="80" height="80">
FILE TRACK HISTORY
<img src="image/filetrack2.png" width="80" height="80"></p>
<p align="center">
<table class="table1" >
 <thead align="center">
<tr >
<td> S.NO </td>
<td> SENDER </td>
<td> SENDER`S REMARKS </td>
<td> RECEIVER </td>
<td> NO. OF DAYS </td>
</tr>
</thead>
<tbody>
<?php
$sql="SELECT file_track.*, empS.name as sendername, empR.name as receivername
FROM (((file_track
left JOIN employee as empS on file_track.sender_id = empS.e_id)
LEFT JOIN employee as empR on file_track.receiver_id = empR.e_id)
 LEFT JOIN files on file_track.f_id = files.f_id) WHERE files.f_id='$id' ORDER BY(file_track.sender_timestamp) ";
$result = mysqli_query($conn, $sql);
$i=1;
while($row = mysqli_fetch_array($result))
{

 $remarks = $row["ft_remarks"];
 $s_time = date('d-m-Y h:i A', strtotime($row["sender_timestamp"]));
 $s_date = date('Y-m-d', strtotime($row["sender_timestamp"]));
 $r_date = date('Y-m-d', strtotime($row["receiver_timestamp"]));
 if( $row["receiver_timestamp"] == "" )
 { $r_time = "Not Acknowledged"; }
 else
 { $r_time = date('d-m-Y h:i A', strtotime($row["receiver_timestamp"])); }

 $sendername=$row["sendername"];
 $receivername=$row["receivername"];
 // printing of no of days
$datediff;
if($row["date_diff"]=="")
{ ////
if($row["receiver_timestamp"] == "")
{
/*caldays($row["sender_timestamp"]);*/
$sql2 = " select DATEDIFF(CURRENT_TIMESTAMP, '".$s_date."') as numdays ";$result2 = mysqli_query($conn, $sql2);
while($row2 = mysqli_fetch_array($result2))
extract($row2);
$GLOBALS['datediff'] = $numdays;
}
else
{
/*caldays($row["receiver_timestamp"]);*/
$sql3 = " select DATEDIFF('".$r_date."', '".$s_date."') as ndays ";
//echo $sql3;
$result3 = mysqli_query($conn, $sql3);
while($row3 = mysqli_fetch_array($result3))
extract($row3);
$ndays;
$sql2 = " select DATEDIFF(CURRENT_TIMESTAMP, '".$r_date."') as numdays ";$result2 = mysqli_query($conn, $sql2);
while($row2 = mysqli_fetch_array($result2))
extract($row2);
$GLOBALS['datediff'] = $numdays; //"( ".$ndays." + ".$numdays." ) ";
}
} ////
else
{
$sql3 = " select DATEDIFF('".$r_date."', '".$s_date."') as ndays ";
//echo $sql3;
$result3 = mysqli_query($conn, $sql3);
while($row3 = mysqli_fetch_array($result3))
extract($row3);
$ndays;
$GLOBALS['datediff'] = $row["date_diff"];//"( ".$ndays." + ".$row["date_diff"]." ) ";
}
 $colour;
 if($GLOBALS['datediff'] > 3)
 { $GLOBALS['colour'] = "#CC0000"; }
 else
 { $GLOBALS['colour'] = "inherit"; }
 ?>
<tr style ="color:<?php echo $GLOBALS['colour']; ?>; " >
 <td width="4%" align="center"><?php echo $i ; ?></td> <td><?php echo '<abc class="name">'.$sendername.' </abc> <br> <abc
class="timestamp">'.$s_time.' </abc> ' ; ?> </td>
<td><?php echo $remarks ; ?></td>
<td><?php echo '<abc class="name">'.$receivername.' </abc> <br> <abc
class="timestamp">'.$r_time .' </abc> ' ; ?></td>
<td align="center" width="10%"> <?php echo $GLOBALS['datediff'] ; ?></td>
</tr>
<?php $i=$i+1;
}
 ?>
 </tbody>
</table>
</p>
<?php
$sql4 = " select * from file_track where ft_id = ". $_GET['ftid'] ." ";
$result4 = mysqli_query($conn, $sql4);
while($row4 = mysqli_fetch_array($result4))
extract($row4);
$ft_action;
if($_GET['page']=="inbox" && $ft_action == 0)
{ ?>
<p>&nbsp;</p>
<p align="center" class="font36"><img src="image/fileaction2.png" alt="DA" width="80" height="80">
FILE ACTION
<img src="image/fileaction2.png" width="80" height="80"></p>
<p>&nbsp;</p>
<p>
<!--<form action="frwd.php?ftid=<?php //echo $_GET['ftid']."&fileid=".$_GET['fileid']."&page=".$_GET['page']; ?>"
method="post">-->
<div align="center" >
<div class="markdiv">
<div class="submark">
<h3>MARK FILE</h3>
</div>
<div class="submark" >
<label >REMARKS</label>
<input name="remarks1" type="text"><br> <span style="color:#CC0033" > [Please do not use
special characters in remarks]</span>
</div>
<div class="submark">
<label>MARK TO</label>
<select name="empid">
<?php
//////////////////////////////////////////////////////////////////////////
if($_SESSION['rolename']=="AD")
//////////////////////////////////////
{ $sql3 = " select employee.*, e_group.g_name,
role.short_name from ( ( employee join e_group on employee.group_id = e_group.id ) join role on employee.role_id = role.id )
where role.short_name not in ('AD', 'GH', 'USER', 'HMMG',
'ADMSG', 'HMSG', '".$_SESSION['rolename']."', 'RS', 'SU') and employee.status = 1 ORDER BY employee.role_id desc " ; }
else if($_SESSION['rolename']=="DISP_MMG")
//////////////////////////
{ $sql3 = " select employee.*, e_group.g_name,
role.short_name from ( ( employee join e_group on employee.group_id = e_group.id ) join role on employee.role_id = role.id )
where role.short_name not in ('USER',
'".$_SESSION['rolename']."', 'AD', 'HMSG', 'ADMSG' , 'RS', 'SU') and employee.group_id in ($group_id, 22) and
employee.status = 1 or employee.e_id = $emphead ORDER BY employee.role_id desc " ; }
else if($_SESSION['rolename']=="DISP_MSG")
///////////////////////////
{ $sql3 = " select employee.*, e_group.g_name,
role.short_name from ( ( employee join e_group on employee.group_id = e_group.id ) join role on employee.role_id = role.id )
where role.short_name not in ('USER',
'".$_SESSION['rolename']."', 'AD', 'HMMG', 'RS', 'SU' ) and employee.group_id in ($group_id, 22) and employee.status = 1 or employee.e_id = $emphead ORDER BY employee.role_id desc " ; }
else
///////////////////////////////////////////////////////////////
{ $sql3 = " select employee.*, e_group.g_name,
role.short_name from ( ( employee join e_group on employee.group_id = e_group.id ) join role on employee.role_id = role.id )
where role.short_name not in ('USER',
'".$_SESSION['rolename']."', 'AD', 'RS', 'SU' ) and employee.group_id in ($group_id, 22) and employee.status = 1 or
employee.e_id = $emphead ORDER BY employee.role_id desc " ; }
//echo $sql3;
$result3= mysqli_query($conn , $sql3 );
while($row3 = mysqli_fetch_array($result3))
{ ?>
<option value="<?php echo $row3['e_id']; ?>"><?php echo
$row3['name']." (".$row3['short_name'].")"; ?></option>
<?php }
///////////////////////////////////////////////////////////////////////////
$role = array("DISP_MMG", "HMMG");
if( $_SESSION['groupid'] == 12 ||
in_array($_SESSION['rolename'],$role) )
{ $sql4 = " select employee.*, e_group.g_name,
role.short_name from ( ( employee join e_group on employee.group_id = e_group.id ) join role on employee.role_id = role.id )
where employee.group_id = 12 and employee.role_id = 4 and employee.status = 1 ORDER BY employee.role_id asc ";
//echo $sql4;
$result4= mysqli_query($conn , $sql4 );
while($row4 = mysqli_fetch_array($result4))
{ ?>
<option value="<?php echo $row4['e_id']; ?>"><?php echo
$row4['name']." (".$row4['g_name'].")"; ?></option>
<?php }
}
///////////////////////////////////////////////////////
$role = array("DISP_MSG", "HMSG", "ADMSG");
if( $_SESSION['groupid'] == 11 ||
in_array($_SESSION['rolename'],$role) )
{ $sql4 = " select employee.*, e_group.g_name,
role.short_name from ( ( employee join e_group on employee.group_id = e_group.id ) join role on employee.role_id = role.id )
where employee.group_id = 11 and employee.role_id = 4 and employee.status = 1 ORDER BY employee.role_id asc ";
//echo $sql4;
$result4= mysqli_query($conn , $sql4 );
while($row4 = mysqli_fetch_array($result4))
{ ?>
<option value="<?php echo $row4['e_id']; ?>"><?php echo
$row4['name']." (".$row4['g_name'].")"; ?></option>
<?php }
}
?>
</select>
</div>
<div class="submark">
<button class="ini-button" onClick="return confirm('Are You Sure to Mark this File?');"
name="mark_to">MARK</button>
</div>
</div>
 <?php if($_SESSION['rolename'] == "HMMG") {?>
<div class="markdiv">
<div class="submark">
<h3>CLOSE FILE</h3>
</div>
<div class="submark">
<label>REMARKS</label>
<input name="remarks2" type="text"><br> <span style="color:#CC0033" > [Please do not use
special characters in remarks]</span>
</div>
<div class="submark">
<label>&emsp;&emsp;</label>
</div>
<div class="submark">
<button class="ini-button" onClick="return confirm('Are You Sure to Close this File?');"
name="closefile">Close File</button>
</div>
</div>
 <?php } ?>
</div>
</p>
<?php } ?>
</form>
<div align="center">
<button class="ini-button" style="padding:2px;" onClick="window.print()"><img src="image/print2.png"
width="60" height="35"></button> &emsp;&emsp;
 <input class="ini-button" type="button" name="back" value="BACK" onClick="location.href='<?php echo
$_GET['page'];?>.php'" />
</div>
<br>
</div>
<?php //include 'includes/footer.php'; ?>
</body>
</html>
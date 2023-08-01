<?php
 include 'includes/dbconnect.php';
header("Refresh:180 ; url=".$_SERVER['PHP_SELF']." ");
date_default_timezone_set("Asia/Kolkata");
$timestamp1 = date('Y-m-d H:i:s');
if(isset($_GET['ftid']))
{
$sql = " update file_track set ft_status = 1, receiver_timestamp='$timestamp1' where ft_id = ".$_GET['ftid']." ;";$result = mysqli_query($conn , $sql);
/*if($result)
{echo "true";}
else
{echo "false";}*/
}
?>
<html>
 <head>
 <link rel="stylesheet" href="includes/style.css" >
 <link rel="stylesheet" href="includes/style2.css" >
<script src="includes/filter.js"></script>
 <!-- Required meta tags -->
 <meta charset="utf-8">
 <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
 <!-- Bootstrap CSS -->
 <title>FTS | Inbox</title>
 </head>
<body class="inbox-bg">
<?php include 'includes/header.php';
 include 'includes/nav.php'; ?>
<p>&nbsp;</p>
<p align="center" class="font36"><strong><img src="image/inbox1.png" alt="da" width="80" height="80"></strong>
INBOX <strong><strong><img src="image/inbox1.png" alt="da" width="80" height="80"></strong></strong></p><p>&nbsp;</p>
<p>&nbsp;</p>
<!-- Filtering and searching options -->
<input type="radio" id="searchBySubject" value="searchBySubject" onclick="$('#search1').show();">
<label for="searchBySubject">Search by Subject</label>
<div id="search1" style="display:none;">
<p align="left" >
Search by subject:
<input id="myInput" type="text" onKeyUp="myFunction()" placeholder="Search .." title="Type" ></p>
</div>
<input type="radio" id="searchByLetterDate" value="searchByLetterDate" onclick="$('#search2').show();"><label for="searchByLetterDate">Search by Letter Date</label>
<div id="search2" style="display:none;">
<p align="right">
Search by letter date: Between <input id="fromdate" type="date" name="fromdate"> and <input id="todate"
type="date" name="todate">
</p>
<input type="button" onKeyUp="filterByLetterDate()"
</div>
<input type="radio" id="searchByLetterNo" value="searchByLetterNo" onclick="$('#search3').show();">
<label for="searchByLetterNo">Search by Letter Number</label>
<div id="search3" style="display:none;">
<p align="left">
Search by letter number:
<input id="letterno" type="text" onKeyUp="filterByLetterno" placeholder="Search" name="letterno"></p>
</div>
<input type="radio" id="searchByDocketDate" value="searchByDocketDate" onclick="$('#search4').show();"><label for="searchByDocketDate">Search by Docket date</label>
<div id="search4" style="display:none;">
<p align="right">
Search by docket date: Between <input id="fromdate" type="date" name="fromdate"> and <input id="todate" type="date" name="todate">
</p>
</div>
<input type="radio" id="searchByReply" value="searchByReply" onclick="$('#search5').show();">
<label for="searchByReply">Search by reply</label>
<div id="search5" style="display:none;">
<p align="left">
Search by reply(YES/NO):
<input type="radio" id="yesreplied" name="yesreplied" value="yes">
<label for="yesreplied">YES</label>
<input type="radio" id="noreplied" name="noreplied" value="no">
<label for="noreplied">NO</label>
</p>
</div>
<input type="radio" id="searchByReplyType" value="searchByReplyType" onclick="$('search6').show();">
<label for="searchByReplyType">Search by reply type</label>
<div id="search6" style="display:none">
<p align="right">
<select name="replytypes" id="replytypes">
<option value="Search by reply type" disabled selected hidden>
<option value="NFA">NFA</option>
<option value="Reply">Reply</option>
<option value="Approval">Approval</option>
</select>
</p>
</div>
<input type="radio" id="searchByLetterMode" value="searchByLetterMode" onclick="$('search7').show();"><label for="searchByLetterMode">Search by Letter mode</label>
<p align="left">
<select name="lettermodes" id="lettermodes">
<option value="Search by letter mode" disabled selected hidden>
<option value="letter">letter</option>
<option value="FAX">FAX</option>
<option value="email">email</option>
</select>
</p>
</div>
<input type="radio" id="searchByMeMarkedLetters" value="searchByMeMarkedLetters" onclick="$('search8').show(); showMeMarkedLetters(<?php echo $_SESSION['username']; ?>);">
<label for="searchByMeMarkedLetters">Search Letters marked for me</label>
<p align="center">
<table class="table1" >
 <thead>
 <tr >
 <td> S. NO. </td>
<td> DOCKET DATE </td>
<td> CATEGORY </td>
<td> LETTER MODE </td>
<td> ESTABLISHMENT NAME </td>
<td> LETTER NUMBER </td>
<td> LETTER DATE </td>
<td> SUBJECT </td>
<td> UPLOADED FILE NAME </td>
<td> SENDER </td>
<td> MARKED TO </td>
<td> REMARK TYPE </td>
<td> REPLY TYPE</td>
<td> REPLIED(Yes/No) </td>
<td> REPLY </td>
<td> VIEW </td>
 <!-- <td> S.NO </td>
 <td> PROJECT NAME/NO. </td>
 <td> FILE NAME </td>
 <td> INITIATOR </td>

 <td> SENDER </td>

 <td> DOCKET NUMBER </td>

 <td> FILE SENT TIME </td>

 <td> ACKNOWLEDGEMENT </td>
 <td> ACTION </td>
 </tr>-->
</thead>
<tbody id="myTable">
<?php $sql="SELECT file_track.*, files.*, initr.name as initiatorname, e_group.g_name, desig.name as designame,
project.proj_name, sendr.name as sender_name
FROM ( ( ( ( ( ( file_track left JOIN files on file_track.f_id = files.f_id ) left JOIN employee as initr ON files.e_id = initr.e_id ) left JOIN e_group ON initr.group_id = e_group.id ) left JOIN desig ON initr.desig_id = desig.id ) left JOIN project ON
files.proj_id = project.id ) left JOIN employee as sendr ON file_track.sender_id = sendr.e_id )
where file_track.receiver_id = ".$_SESSION['userid']." and file_track.ft_action = 0 and files.f_status = 1 ORDER BY
file_track.sender_timestamp DESC";
$result = mysqli_query($conn, $sql);
$i=1;
while ($row = mysqli_fetch_array($result)) {
?>
<tr>
 <td align="center"> <?php //echo "$i" ;?></td>
 <td><?php echo date('d-m-Y h:i A', strtotime($row["sender_timestamp"])); ?></td>
 <td><?php echo $row["category"]; ?></td> <!-- siddharth -->
 <td><?php echo $row["letter_mode"]; ?></td> <!-- siddharth -->
 <td><?php echo $row["letter_date"]; ?></td> <!-- siddharth -->
 <td><?php echo $row["letter_subject"]; ?></td> <!-- siddharth -->
 <td><?php echo $row["uploaded_file_name"]; ?></td> <!-- siddharth --> <td><?php echo $row["sender_name"]; ?></td> <!-- siddharth -->
 <td><?php echo $row ["letter_marked_to"]; ?></td> <!-- siddharth -->
 <td><?php echo $row ["remark_type"]; ?></td> <!-- siddharth -->
 <td><?php echo $row ["reply_type"]; ?></td> <!-- siddharth -->
 <td><?php echo $row [

 <td> <?php echo $row["proj_name"] ;?></td>
 <td><?php echo $row["file_name"]; ?></td>
 <td><?php echo $row["initiatorname"]. ',<br>' .$row["designame"]. ',<br>'
.$row["g_name"] ; ?></td>

 <!--<td><?php //echo $row["g_name"]; ?></td> -->




 <?php if($row["ft_status"]==0) {?> <td align="center"> <button class="ini-button"
id="myButton" onclick ="location.href='inbox.php?ftid=<?php echo $row['ft_id']."&fileid=".$row['f_id'];?>'"> ACK
</button> </td> <?php } else { echo '<td>'.date('d-m-Y h:i A', strtotime($row["receiver_timestamp"])).'</td>'; }?>

 <?php if($row["ft_status"]==0) { echo '<td> Not Acknowledged </td>'; } else { ?> <td
align="center"> <button class="ini-button" id="myButton" onclick ="location.href='view.php?ftid=<?php echo
$row['ft_id']."&fileid=".$row['f_id']."&page=inbox";?>'"> VIEW </button> </td> <?php } ?>
</tr>
<?php
$i++;
}
?>
</tbody>
</table>
 </p>
<?php //include 'includes/footer.php'; ?>
</body>
</html>
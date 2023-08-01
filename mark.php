<?php
 include 'includes/dbconnect.php';
session_start();
$showAlert = false;
$showError = false;
?>
<!doctype html>
 <head>
 <!-- Required meta tags -->
 <meta charset="utf-8">
 <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
 <!-- Bootstrap CSS -->
 <link rel="stylesheet" href="includes/style.css" >
 <link rel="stylesheet" href="includes/style2.css" >
 <script src="includes/filter.js"></script>
 <title>FTS | Mark File</title>
 </head>
 <body class="initiate-bg">
 <?php include 'includes/header.php';
 include 'includes/nav.php'; ?>
 <?php
 if($showAlert){
echo ("<script LANGUAGE='JavaScript'>
 window.alert('Succesfully Updated');
 window.location.href='done.php';
 </script>");

 }
 if($showError){
 echo ' <div class="alert alert-danger alert-dismissible fade show" role="alert">
 <strong>Error!</strong> '. $showError.'
 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
 <span aria-hidden="true"> </span>
 </button>
 </div> ';
 }
 ?>
<?php
$id = $_GET['fileid'];
$sql1="SELECT files.*, employee.name as empname, desig.name as designame, e_group.g_name,
category.cat_name, project.proj_name, portal.portal_name, bidding_mode.bid_mode, financial_year.fin_year FROM ( ( ( ( ( ( ( ( files JOIN employee ON files.e_id = employee.e_id ) JOIN desig ON employee.desig_id = desig.id ) JOIN category ON files.cat_id = category.id ) JOIN project ON files.proj_id = project.id ) JOIN portal ON files.port_id = portal.id ) JOIN
bidding_mode ON files.bid_id = bidding_mode.id ) JOIN financial_year ON files.fin_id = financial_year.id ) JOIN e_group on employee.group_id = e_group.id ) where files.f_id=$id";
$result1 = mysqli_query($conn, $sql1);
while($row1= mysqli_fetch_array($result1))
extract($row1);
?>
 <div align="center">
 <p>&emsp;</p>
 <h1 class="font36"><img src="image/draft2.png" alt="draft" width="80" height="80"> DRAFT FILE <img
src="image/draft2.png" alt="draft" width="80" height="80"></h1>
 <form action="includes/mark_action.php" method="post">
 <div class="ini-group">
 <label for="name">Name</label>
 <input value="<?php echo $empname; ?>" type="text" id="name" name="user_name" readonly=""> </div>
<div class="ini-group">
 <label for="desig">Designation</label>
 <input value="<?php echo $designame; ?>" type="text" id="desig" name="desig" readonly="">
 </div>
<div class="ini-group">
 <label for="file_name">File Name <abc class="mand">*</abc> </label>
 <input value="<?php echo $file_name; ?>" type="text" id="file_name" name="file_name" required>
<input value="<?php echo $_GET['fileid']; ?>" style="display:none;" type="text" id="fid"
name="fid">
</div>
<div class="ini-group">
 <label for="Docket_Number">Docket Number</label>
 <input value="<?php if( $docket_no == "" ) echo $g_name."/".$fin_year."/".$_GET['fileid'] ; else echo
$docket_no; ?>" type="text" id="docket_no" name="docket_no" readonly="">
</div>
 <div class="ini-group">
 <label for="group">File Description <abc class="opt">( Optional )</abc></label>
 <textarea name="description" id="description"><?php echo $description; ?></textarea>
 </div>

 <div class="ini-group">
<label for="cat">Category <abc class="mand">*</abc></label>
<select name="cat_id" id="cat_id" required>
<?php
$sql4 = " select * from category ";
$result4 = mysqli_query($conn, $sql4);
while($row4= mysqli_fetch_array($result4)) { ?>
 <option value="<?php echo $row4['id']; ?>" <?php if($row4['id']==$cat_id) echo "selected";?> > <?php echo
$row4['cat_name']; ?></option>
<?php } ?>
</select>
</div>

 <div class="ini-group">
 <label for="project_no">Project Name/No. <abc class="mand">*</abc></label>
 <select id="proj_id" name="proj_id" required >
<?php
$sql4 = " select * from project ";
$result4 = mysqli_query($conn, $sql4);
while($row4= mysqli_fetch_array($result4)) { ?>
 <option value="<?php echo $row4['id']; ?>" <?php if($row4['id']==$proj_id) echo "selected";?> ><?php echo
$row4['proj_name']; ?></option>
<?php } ?>
</select>
</div>
<div class="ini-group">
<label for="mode">Portal <abc class="mand">*</abc></label>
<select name="port_id" id="port_id" required>
<?php
$sql4 = " select * from portal ";
$result4 = mysqli_query($conn, $sql4);
while($row4= mysqli_fetch_array($result4)) { ?>
 <option value="<?php echo $row4['id']; ?>" <?php if($row4['id']==$port_id) echo "selected";?> ><?php echo
$row4['portal_name']; ?></option>
<?php } ?>
</select>
 </div>
 <div class="ini-group">
<label for="mode">Bidding Mode <abc class="mand">*</abc></label>
<select name="bid_id" id="bid_id" required>
<?php
 $sql4 = " select * from bidding_mode ";
$result4 = mysqli_query($conn, $sql4);
while($row4= mysqli_fetch_array($result4)) { ?>
 <option value="<?php echo $row4['id']; ?>" <?php if($row4['id']==$bid_id) echo "selected";?> ><?php echo
$row4['bid_mode']; ?></option>
<?php } ?>
</select>
 </div>
<div class="ini-group">
 <label for="qty">Quantity <abc class="mand">*</abc></label>
 <input value="<?php echo $quantity; ?>"type="number" id="quantity" name="quantity" required> </div>
<div class="ini-group">
 <label for="cst">Total Cost (in Rupees) <abc class="mand">*</abc></label>
 <input value="<?php echo $total_cost; ?>" type="number" id="total_cost" name="total_cost" required> </div>
<div class="ini-group">
<label for="fin_year">Financial Year <abc class="mand">*</abc></label>
<select name="fin_id" id="fin_id" required>
<?php
$sql4 = " select * from financial_year where status = 1 ";
$result4 = mysqli_query($conn, $sql4);
while($row4= mysqli_fetch_array($result4)) { ?>
<option value="<?php echo $row4['id']; ?>" <?php if($row4['id']==$fin_id) echo
"selected";?> ><?php echo $row4['fin_year']; ?></option>
<?php } ?>
</select>
</div>
 <div class="ini-group">
 <label for="remarks">User Remarks/Purpose <abc class="opt">( Optional )</abc></label>
 <textarea name="remark" id="remark"><?php echo $f_remark; ?></textarea>
</div>

 <br>

 <div class="ini-group" align="left">
 <input style="display:inline-block; width:5%;" type="checkbox" id="adna" name="adna" value="1"
onClick="displaybtn()">
 <label style="display:inline-block; width:75%" for="checkbox" >Please check if AD/GH is not available<!--<abc
class="opt">( Optional )</abc>--></label>
</div>
<?php if($_SESSION['rolename'] == "USER")
{ ?>
 <button type="submit" name="update" class="btn btn-primary">UPDATE </button>&emsp;&emsp;
<button type="submit" id="mark_ad" name="mark_ad" onClick="return confirm('Are You Sure to Mark this
File?');" class="btn btn-primary">MARK TO AD </button>
 <button type="submit" id="mark_su" name="mark_su" style="display:none;" onClick="return confirm('Are You Sure to Mark this File?');" class="btn btn-primary">MARK TO SU </button>&emsp;&emsp;
<input type="button" class="btn btn-primary" onClick="location='draft.php'" name="backbtn" value="Back" />
<?php }
else if($_SESSION['rolename'] == "AD" || $_SESSION['rolename'] == "GH") { ?>
<button type="submit" name="mark_mmg" onClick="return confirm('Are You Sure to Mark this File?');"
class="btn btn-primary">MARK TO MMG </button>&emsp;&emsp;
<input type="button" class="btn btn-primary" onClick="location='draft.php'" name="backbtn" value="Back" /><?php } ?>

 </form>
 </div>
 </div>
 <p>&emsp;</p>
 <p>&emsp;</p>

 </body>
</html>
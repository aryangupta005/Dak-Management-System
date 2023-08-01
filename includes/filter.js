// JavaScript Document
function myFunction() { // filters letters by subject name
 var input, filter, table, tr, td, i;
 input = document.getElementById("myInput");
 filter = input.value.toUpperCase();
 table = document.getElementById("myTable");
 tr = table.getElementsByTagName("tr");
 for (var i = 0; i < tr.length; i++) {
 var tds = tr[i].getElementsByTagName("td");
 var flag = false;
 //for(var j = 0; j < tds.length; j++){
 var td = tds[7];
 if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
 flag = true;
 }
 if(flag){
 tr[i].style.display = "";
 }
 else {
 tr[i].style.display = "none";
 }
 }
}
function filterByLetterDate(){
// var frominput=document.getElementById("
}
function showMeMarkedLetters(username){
var table=document.getElementById("myTable");
tr = table.getElementsByTagName("tr");
for(var i = 0; i < tr.length; i++){
var tds=tr[i].getElementByTagName("td");
var flag=false;
var markedTo = tds[10];
if(markedTo.toUpperCase().equals(username.toUpperCase())){
flag=true;
}
if(flag){
tr[i].style.display = "";
}
else {
tr[i].style.display = "none";
}
}
}
function filterByLetterNo(){
 var input, filter, table, tr, td, i;
 input = document.getElementById("myInput");
 filter = input.value.toUpperCase();
 table = document.getElementById("myTable");
 tr = table.getElementsByTagName("tr");
 for (var i = 0; i < tr.length; i++) {
 var tds = tr[i].getElementsByTagName("td");
 var flag = false;
 var td = tds[5];
 if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
 flag = true;
 }
 }
 if(flag){
 tr[i].style.display = "";
 }
 else {
 tr[i].style.display = "none";
 }
}
function displaybtn()
{
var chkbx=document.getElementById("adna");
var ad=document.getElementById("mark_ad");
var su=document.getElementById("mark_su");
if(chkbx.checked == true)
{
su.style.display = "inline-block";
ad.style.display = "none";
}
else
{
su.style.display = "none";
ad.style.display = "inline-block";
}
}
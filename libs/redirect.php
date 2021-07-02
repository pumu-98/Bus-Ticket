<?php 
$currentuser=getLoggedMemberID();
if ($currentuser=="guest") {
   
  redirect("index.php?signIn=1");
}

 ?>
<?php 
function alertcheck(){
	include("db_connect.php");
	$currentuser=getLoggedMemberID();
	if ($currentuser<>"admin") {
 
		$sql="SELECT * FROM membership_userrecords WHERE tableName='customers' AND memberID='$currentuser'";
		$result=mysqli_query($con,$sql);
		$rowcount=mysqli_num_rows($result);
		if ($rowcount==0) {
		 
			echo '<div class="alert alert-info">
			<strong>Hello '.$currentuser.'</strong> You have no data in our customers records,kindly submit your data so that you can enjoy our services!!.
			</div>';
		}
	}
}
function countrecords($table){
	include("db_connect.php");
	$currentuser=getLoggedMemberID();
	if ($currentuser=="admin") {
 
		$sql="SELECT * FROM $table ORDER BY id";
		$result=mysqli_query($con,$sql);
		$rowcount=mysqli_num_rows($result);
		echo $rowcount;
	}
	else {
 
		if ($table=="customers") {
		    
			$sql="SELECT * FROM membership_userrecords WHERE tableName='$table' AND memberID='$currentuser'";
			$result=mysqli_query($con,$sql);
			$rowcount=mysqli_num_rows($result);
			echo $rowcount;
		}
		elseif ($table=="bookings") {
	 
			$sql="SELECT * FROM membership_userrecords WHERE tableName='$table' AND memberID='$currentuser'";
			$result=mysqli_query($con,$sql);
			$rowcount=mysqli_num_rows($result);
			echo $rowcount;
		}
		else{
	 
			$sql="SELECT * FROM $table ORDER BY id";
			$result=mysqli_query($con,$sql);
			$rowcount=mysqli_num_rows($result);
			echo $rowcount;
		}
	}

}
function duetoday($table){
	include("db_connect.php");
	$todaydate=date('Y-m-d');
 
	$sql="SELECT id AS dateid FROM availability WHERE date='$todaydate' ORDER BY id";
	$result=mysqli_query($con,$sql);
	foreach ($result as $currdate => $cdate) {
	 
		$cdid=$cdate['dateid'];
	}
	$sql="SELECT * FROM $table WHERE date='$cdid'";
	$result=mysqli_query($con,$sql);
	$rowcount=mysqli_num_rows($result);
	if ($rowcount==0) {
		 
		echo '<div class="alert alert-success">
		<strong>No Bookings Due Today</strong>.
		</div>';
	}
	foreach ($result as $allbookings => $booking) {
 
		$customerid=$booking['id_number'];
		$seatid=$booking['seat'];
		$busid=$booking['bus'];
		$amtid=$booking['amount'];
		$dateid=$booking['date'];
		 
		$sql="SELECT * FROM customers WHERE id='$customerid'";
		$result=mysqli_query($con,$sql);
		foreach ($result as $allcustomers => $cdetails) {
			 
			$fullname=$cdetails['fullname'];
			$phone=$cdetails['phone'];
			$id_number=$cdetails['id_number'];
		}
		 
		$sql="SELECT * FROM buses WHERE id='$busid'";
		$result=mysqli_query($con,$sql);
		foreach ($result as $albuses => $busdetails) {
		 
			$bus=$busdetails['number'];
		}
		 
		$sql="SELECT * FROM seats WHERE id='$seatid'";
		$result=mysqli_query($con,$sql);
		foreach ($result as $allseats => $seatdetails) {
			 
			$seat=$seatdetails['name'];
		}
	 
		$sql="SELECT * FROM availability WHERE id='$dateid'";
		$result=mysqli_query($con,$sql);
		foreach ($result as $allavailability => $availabilitydetails) {
			 
			$date=$availabilitydetails['date'];
			$time=$availabilitydetails['time'];
		}
		 
		$sql="SELECT * FROM routes WHERE id='$amtid'";
		$result=mysqli_query($con,$sql);
		foreach ($result as $allamounts => $amountdetails) {
		 
			$amount=$amountdetails['amount'];
		}
		 
		echo '<tr>
		<td>'.$id_number.'</td>
		<td>'.$fullname.'</td>
		<td>'.$phone.'</td>
		<td>'.$bus.'</td>
		<td>'.$seat.'</td>
		<td>'.$date.'</td>
		<td>'.$time.'</td>
		<td>'.$amount.'</td>
		<td>'.$booking['date_booked'].'</td>
		</tr>';
	}
}


?>
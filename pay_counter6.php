<?php
	session_start();
?>
<?php
include 'connect.php';
include 'gen_id.php';
$stat= 0;
?>
<!DOCTYPE html>
<html>
<head>
<!--<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />-->
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>ALLOWANCE SYSTEM</title>

<!--css utk bootstrap -->
<link rel="stylesheet" href="css/bootstrap.min.css">
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<!--css utk menu -->
<link rel='stylesheet' href='css/styles.css'>
<script src='js/script.js' type='text/javascript'></script>

<?php
echo($mycss1.$mycss2.$mycss3.$mycss4.$mycss5.$myjs.$myjs2.$myjs3.$myjs5.$myjs6)
?>
</head>
<body>
<?php
	include 'menu.php';
	?>
<div class="container">
<div id='content' style='width:100%;'>
<?php
if($_POST["pay"])
{
		$payment= $_POST['payment'];
		$allowance_id = $_REQUEST["allowance_id"];

		$sql1 = "INSERT INTO pay_transaction(allowance_id, amount,claimed) VALUES('$allowance_id', '$payment','0')";
		$result1 = mysqli_query($conn, $sql1);

		echo($sql1);
		echo("<br>Transcetion for ".$allowance_id."with amount ".$payment." is Succesfull save...");


			echo("<br><br><a href =\"index.php\"> <center> redirect page..... </a>");
		   	echo("\n <script>");
			echo("\n setTimeout(\"location.href='".$_SERVER['PHP_SELF']. "'\", 500) ");
			echo("\n </script>");

}


elseif($_POST["next"])
{
$allowance_id = $_REQUEST["allowance_id"];
$student_ic = $_REQUEST["allowance_id"];
	/*
$sql1="SELECT tblstudent.student_ic, pay_id.student_id FROM tblstudent, pay_id WHERE (pay_id.student_id = tblstudent.student_ic) && (pay_id.allowance_id='".$allowance_id."')"	;
	echo $sql1;
$query1 = mysqli_query($conn, $sql1);
$row1 = mysqli_fetch_array($query1, MYSQLI_NUM);
$student_ic = $row1[0];
	*/


	// Search pay_allowance ada tak nama nie...

	?>
	<br>
	<br>
	<br>
	<form action="<?php echo($_SERVER['PHP_SELF']);?>" method="post" form role="form">
	<div class="form-group">
	<table border="0" align="center" class="table table-striped table-bordered">
	<tr>
	  <td width="18%">NAME</td>
	  <td>
	  		<?php
	//Select student_id from .... where allowance_id =$allowance_id
	//student_id



			$query_parent3 = mysqli_query($conn, "SELECT allowance_id, student_name, start_date, end_date, amount_per_month FROM pay_allowance WHERE allowance_id = '$allowance_id'");

			if($row3 = mysqli_fetch_array($query_parent3, MYSQLI_NUM)) {

			$batch = $row3[1];
			$amount = number_format($row3[6],2);
			$start_date = $row3[2];
			$end_date = $row3[3];
			} else {
				// Student not in title for allowance
			}


			$query_parent = mysqli_query($conn, "SELECT student_ic, student_name FROM tblstudent WHERE student_ic = '$student_ic'");

			$row = mysqli_fetch_array($query_parent, MYSQLI_NUM);
			$name = $row[1];

			echo($batch);

		?>

		<input class="form-control" type="hidden" name="name" value="<?php echo($name); ?>"/>
		<input class="form-control" type="hidden"  name="batch_name" value="<?php echo($batch); ?>"/>
		<input class="form-control" type="hidden"  name="allowance_id" value="<?php echo($allowance_id); ?>"/>
		<input class="form-control" type="hidden" name="amount" value="<?php echo($amount); ?>"/>

		</td>
	</tr>
    <!--
     ruang untuk batch
	<tr>
	  <td>BATCH NAME</td>
	  <td><?php echo($batch); ?>
		</td>
	</tr>
    -->
	<tr>
		<td>BUDGET PER MONTH (RM)</td>
		<td>
			<?php echo($amount); ?>
		</td>
	</tr>
	</table>


	<?php
		$no = 0;
		$total = 0 ;
	//	$sql_tot="SELECT SUM(amount) as mytot FROM pay_transaction WHERE
	//				(allowance_id = '$allowance_id')
	//				and claimed='0'
	//				and (MONTH(date)=MONTH(NOW()) )";

	$sql_tot="SELECT SUM(amount) as mytot FROM pay_transaction WHERE
					(allowance_id = '$allowance_id')
					and (MONTH(date)=MONTH(NOW()) )";
		$query = mysqli_query($conn,$sql_tot );
		while($tot_row = mysqli_fetch_array($query, MYSQLI_NUM))
		{
			//$no ++;
			$total = $tot_row[0];
		}

	?>

<font size="+5">
	<table border="0" align="center" class="table table-striped table-bordered">

		<tr>
		<td width="50%">Total Expenses : <?php echo(number_format($total,2)); ?></td>
	  <td>Balance To Date : 		<?php
			$balance = 0;
			$balance = $amount - $total;
			echo(number_format($balance,2));
		 ?></td>
	</tr>
	</table>
</font>

	<table border="0" align="center" class="table table-striped table-bordered">

  	<tr>
		<td><font size="+5">PAYMENT (RM)</font></td>
	  <td>
	  	<input  style="font-size:50px;" height="12" type="number" step="any" name="payment" id="payment" autofocus />
	   	<input type="hidden" name="pay" id="pay" value="PAY"/>
	   </td>
	</tr>

	</table>
	</form>
<?php
}

else { ?>

<h2 align="center">&nbsp;</h2>
<form action="<?php echo($_SERVER['PHP_SELF']);   ?>" method="post" form role="form">
<div class="form-group">
<table border="0" align="center" class="table table-striped table-bordered">
<tr>
  <td>ALLOWANCE ID</td>
  <td>
  <input class="form-control" type="text" name="allowance_id" id="allowance_id" autofocus onkeyup="changeToUpperCase(this)"/>
  <input type="hidden" name="next" id="next" value="NEXT"/>
  </td>
</tr>
</table>

</div>
</form>
<?php
}
?>
</div>
</div>
</body>
</html>

<?php
	session_start();
	if($_SESSION['create']==0 || !isset($_SESSION['create']))
		header('Location: main.php');
	$_SESSION['add']=0;
	$u=$_SESSION['user'];
	$count=0;
	
	$conn = mysqli_connect('localhost','root','Aa#123','lithub');
	$users = [];
	$result = mysqli_query($conn,'SELECT * FROM users');
	while ($row = $result->fetch_assoc()) {
		$users[] = $row;
	}
	if(isset($_POST['back']))
	{
		$_SESSION['create']=0;
		header('Location: main.php');
	}
	if(isset($_POST['create']))
	{
		$pname=htmlentities($_POST['pname']);
		$view=htmlentities($_POST['see']);
		
		if($count==0)
			$x=0;
		else
			$x=1;
		
		if($view=='a')
			$y=1;
		else
			$y=0;
		
		mysqli_query($conn,"INSERT INTO userp".$u." (pname,flag,public) Values ('$pname','$x','$y')");
		$_SESSION['project']=$pname;
		$_SESSION['add']=1;
		header('Location: add.php');
	}
?>

<!DOCTYPE html>
<html>
	<head>
		<title>New Project</title>
	<style>
			body
			{
				background-color:grey;
			}
			form
			{
				background-color:white;
				width:20%;
				padding : 10px 20px 10px 20px;
				font-size:25px;
			}
			label
			{
				font-size:30px;
			}
			a
			{
				font-size:25px;
			}
			input
			{
				font-size : 20px;
			}
			#submit
			{
				background-color:lightgreen;
				width:100%;
			}
			h3
			{
				color:red;
			}
		</style>
	</head>
	<body>
		<center>
			<h1>Create Project on Best sharing site!</h1>
			<form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
					<label>Project Name :</label><br>
					<input type="text" name="pname" value="<?php if(isset($_POST['create']) || isset($_POST['add'])) echo $_POST['pname']; else echo ''; ?>" required><br><br>
					<label>Who can see :</label><br>
					<input type="radio" name="see" value="a" checked>Anyone
					<input type="radio" name="see" value="p">Private<br><br>
				<center>
					<input type="submit" name="create" value="Create" id="submit"><br>
				</center>
			</form>
			<form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
				<input type="submit" name="back" value="Cancel" id="submit"><br>
			</form>
		</center>
	</body>
</html>
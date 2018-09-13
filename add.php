<?php
	session_start();
	if($_SESSION['add']==0 || !isset($_SESSION['add']))
		header('Location: create_project.php');
	$pname=$_SESSION['project'];
	$u=$_SESSION['user'];
	$person='';
	$err='';
	$flag=0;
	
	$conn = mysqli_connect('localhost','root','Aa#123','lithub');
	$users = [];
	$result = mysqli_query($conn,'SELECT * FROM users');
	while ($row = $result->fetch_assoc()) {
		$users[] = $row;
	}
	$shares = [];
	$result = mysqli_query($conn,'SELECT * FROM share');
	while ($row = $result->fetch_assoc()) {
		$shares[] = $row;
	}
	
	foreach($shares as $share)
	{
		if($share['user1']==$u && $share['projectname']==$pname)
		{
			foreach($users as $user)
			{
				if($user['id']==$share['user2'])
				{
					$person.=$user['user'].'<br>';
					break;
				}
			}
		}
	}
	if(isset($_POST['back']))
	{
		header('Location: main.php');
		$_SESSION['add']=0;
	}
	if(isset($_POST['add']))
	{
		$p=htmlentities($_POST['person']);
		$pname=$pname;
		foreach($users as $user)
		{
			if($user['user']==$p)
			{
				$flag=$user['id'];
				break;
			}
		}
		if($flag!=0)
		{
			$err='';
			mysqli_query($conn,"INSERT INTO share (user1,user2,projectname,flag) Values ('$u','$flag','$pname','1')");
			$person.=$p.'<br>';
		}
		else
			$err='User not found!';
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
					<label>Share Project with :</label><br>
					<?php echo $person; ?>
					<input type="text" name="person"><br><br>
					<input type="submit" name="add" value="Add" id="submit"><br>
					<input type="submit" name="back" value="Done" id="submit">
					<h3><?php echo $err; ?></h3>
			</form>
		</center>
	</body>
</html>
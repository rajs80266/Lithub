<?php
	$pp=$gp='';
	
	session_start();
	if($_SESSION['login']==0 || !isset($_SESSION['login']))
		header('Location: index.php');
	if(isset($_POST['back']))
	{
		$_SESSION['login']=0;
		header('Location: index.php');
	}
	if(isset($_POST['create']))
	{
		$_SESSION['create']=1;
		header('Location: create_project.php');
	}
	$u=$_SESSION['user'];
	$conn = mysqli_connect('localhost','root','Aa#123','lithub');
	$projects = [];
	$result = mysqli_query($conn,'SELECT * FROM userp'.$u);
	while ($row = $result->fetch_assoc()) {
		$projects[] = $row;
	}
	foreach($projects as $project)
	{
		$pp.='<tr><td>'.$project['pname'].'</td></tr>';
	}
	
	$shares = [];
	$result = mysqli_query($conn,'SELECT * FROM share');
	while ($row = $result->fetch_assoc()) {
		$shares[] = $row;
	}
	
	foreach($shares as $share)
	{
		if($share['user2']==$u && $share['flag']==1)
		{
			$gp.='<tr><td>'.$share['projectname'].'</td></tr>';
		}
	}
?>

<!DOCTYPE html>
<html>
	<head>
		<title>Main</title>
		<style>
			body
			{
				background-color:grey;
			}
			table
			{
				background-color:white;
			}
			th,td
			{
				padding-left:5%;
				padding-right:5%;
			}
			th
			{
				font-size:50px;
				border-bottom : 5px solid black;
			}
			td
			{
				padding : 5% 0% 5% 0%;
				font-size:40px;
				border-bottom : 2px solid black;
			}
			.ci input
			{
				font-size:250%;
				background-color:lightgreen;
				padding:1%;
			}
		</style>
	</head>
	<body>
		<table style="float:left">
			<tr>
				<th><center>My Personal Projects</center></th>
			</tr>
			<?php echo $pp; ?>
		</table>
		<center style="float:left">
			<form class="ci" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
				<input type="submit" value="Create New Project" name="create">
			</form>
		</center>
		<table style="float:right">
			<tr>
				<th><center>My Group Projects</center></th>
			</tr>
			<?php echo $gp; ?>
		</table>
		<center style="float:right">
			<form class="ci" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
				<input type="submit" value="Log Out" name="back">
			</form>
		</center>
	</body>
</html>
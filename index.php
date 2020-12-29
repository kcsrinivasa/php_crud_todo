<?php

//Mysql connection configuration
$serverName = 'localhost';
$userName = 'root';
$password = 'bylyngolsp';
$databaseName = 'test';

$conn = mysqli_connect($serverName,$userName,$password,$databaseName);

if(!$conn){
	die('Mysql connection error : '.mysqli_connect_error());
}
//Mysql table creation - uncomment to create table

/*
$create_table = mysqli_query($conn,"CREATE TABLE IF NOT EXISTS todo(id int PRIMARY KEY AUTO_INCREMENT NOT NULL, name varchar(255))");
if(!$create_table){
	echo "Error : ".mysqli_error($conn);
}
*/
//mysql configuration end

//to insert
if(isset($_POST['add'])){
	$name= $_POST['name'];
	$insert_record = mysqli_query($conn,"INSERT INTO todo SET name = '$name'");
	if(!$insert_record){
		echo "Error : ".mysqli_error($conn);
	}
	header('location:index.php');
}
//to delete
if(isset($_GET['deleteId'])){
	$row_id= $_GET['deleteId'];
	$delete_record = mysqli_query($conn,"DELETE FROM todo WHERE id = '$row_id'");
	if(!$delete_record){
		echo "Error : ".mysqli_error($conn);
	}
	header('location:index.php');
}
//to edit
if(isset($_GET['editId'])){
	$row_id= $_GET['editId'];
	$edit_record = mysqli_query($conn,"SELECT * FROM todo WHERE id = '$row_id'");
	if(!$edit_record){
		echo "Error : ".mysqli_error($conn);
	}
	$edit_record = mysqli_fetch_array($edit_record);
}
//to update
if(isset($_POST['update'])){
	$name= $_POST['name'];
	$row_id= $_POST['row_id'];
	$update_record = mysqli_query($conn,"UPDATE todo SET name = '$name' WHERE id = '$row_id'");
	if(!$update_record){
		echo "Error : ".mysqli_error($conn);
	}
	header('location:index.php');
}

$todo_list = mysqli_query($conn,"SELECT * FROM todo order by id desc");

?>
<!DOCTYPE HTML>
<html>
<head>
<title>TODO</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <meta Http-Equiv="Cache-Control" Content="no-cache">
  <meta Http-Equiv="Pragma" Content="no-cache">
  <meta Http-Equiv="Expires" Content="0"> 

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style type="text/css">
body{
	background-image: linear-gradient(to bottom right, #00d8ff , #1613fd);
    height: 100vh;
}
</style>
</head>
<body>
<div class="row m-3">
	<div class="col-md-3"></div>
	<div class="col-md-6 rounded p-3">
		<div>
			<?php if(isset($_GET['editId'])){ ?>
			<form action="" method="post">
				<div class="input-group">
					<div class="input-group-prepend"><span class="input-group-text p-0"><a href="index.php" class="btn"><i class="fa fa-lg fa-times-circle text-danger"></i></a></span></div>
					<input type="hidden" name="row_id" value="<?php echo $edit_record['id']; ?>">
					<input type="text" name="name" class="form-control" placeholder="Enter TODO Name" value="<?php echo $edit_record['name']; ?>" required>
					<div class="input-group-append"><span class="input-group-text p-0"><button type="submit" class="btn" name="update"><i class="fa fa-lg fa-check-circle text-success"></i></button></span></div>
				</div>
			</form>

			<?php }else{ ?>
			<form action="" method="post">
				<div class="input-group">
					<input type="text" name="name" class="form-control" placeholder="Enter TODO Name" required>
					<div class="input-group-append"><span class="input-group-text p-0"><button type="submit" class="btn" name="add"><i class="fa fa-lg fa-plus-circle text-primary"></i></button></span></div>
				</div>
			</form>
			<?php } ?>

			<?php if(mysqli_num_rows($todo_list)){ ?>
			<table class="table">
				<thead><th class="w-75"></th><th></th></thead>
				<tbody class="rounded font-weight-bold" style="background-color: #f5fdfc78;">
				<?php while($row = mysqli_fetch_array($todo_list)){ ?>
				<tr>
					<td><?php echo $row['name']; ?></td>
					<td><a href="?deleteId=<?php echo $row['id']; ?>"><button class="bg-light text-danger rounded"><i class="fa fa-lg fa-trash"></i></button></a>
						<a href="?editId=<?php echo $row['id']; ?>"><button class="bg-light text-primary rounded"><i class="fa fa-lg fa-pencil"></i></button></a>
					</td>
				</tr>
				<?php } ?>
				</tbody>
			</table>
			<?php }else{ ?>
			<h4 class="text-center my-3"> No Todo list found! </h4>
			<?php } ?>
		</div>



	</div>
</div>



</body>
</html>
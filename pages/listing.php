<?php 	
	if (isset($_GET['id'])){
		$result = $mysqli->query("select image from `posting` where id=" . $_GET['id']);
		if ($result){
			$row = $result->fetch_assoc();
		}
		if (isset($row)){
			$image = $row['image'];
			if (file_exists($image))
							unlink($image);
		}
		$query = "delete from `posting` where id=" . $_GET['id'];
		$mysqli->query($query);
	}

	$query = "SELECT * FROM `posting` ORDER BY `timestamps` DESC";
	$result = $mysqli->query($query);
	if ($result){
		$data = [];
		while($row = $result->fetch_assoc()){
			array_push($data, $row);
		}
	}
?>


<?php 
if (count($data) > 0){
	foreach ($data as $row){ ?>
<div class="panel panel-default">
	<div class="panel-heading panel-default">
		<p>
			<i class="far fa-clock"></i>
			<?php echo $row['timestamps']; ?>
		</p>
	</div>
	<div class="panel-body">
		<?php if ($row['image'] != "") {?>
		<div class="col-md-5">
			<img src="<?php  echo $row['image']?>" style="max-width: 100%" alt="<?php  echo $row['image']?>">
		</div>
		<div class="col-md-7">
			<?php echo nl2br($row['content']); ?>
		</div>
		<?php } else echo nl2br($row['content']); ?>
		<div class="col-md-12">
			<a href="?page=listing&id=<?php echo $row['id'];?>" class="delete">Delete</a>
		</div>
	</div>
</div>
<?php 
	}
} else { 
?>

<div class="panel panel-default">
	<div class="panel-heading panel-default">
		<h4>None of Articles</h4>
	</div>
	<div class="panel-body">
		<p>
			Post in posting page!
		</p>
	</div>
</div>
<?php } 
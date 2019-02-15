<?php
	if (isset($_GET['id'])){
		$result = $mysqli->query("select url from `images` where postid=" . $_GET['id']);
		if ($result){
			$row = $result->fetch_assoc();
		}
		if (isset($row)){
			$image = $row['url'];
			if (file_exists($image)) unlink($image);
		}
		$mysqli->query("delete from `posting` where id=" . $_GET['id']);
		$mysqli->query("delete from `images` where postid=" . $_GET['id']);
	}
	include "components/post_list.php";
?>


<?php 
if (count($data) > 0){
	foreach ($data as $row){ ?>
<div class="panel panel-default">
	<div class="panel-heading panel-default">
		<p>
			<i class="far fa-clock"></i>
			<?php echo $row['timestamps']; ?>
			<span style="float:right">
				By
				<strong>
					<?php echo $row['username'];?>
				</strong>
			</span>
		</p>
	</div>
	<div class="panel-body">
		<?php if (count($row['images']) > 0) {
			echo '<div class="mosaic">';
			foreach ($row['images'] as $image){
			?>
		<img src="<?php  echo $image?>" alt="<?php  echo $image?>">
		<?php }
		echo '</div><div class="col-md-12 row"><hr>' . nl2br($row['content']).'</div>';
	} else echo nl2br($row['content']); ?>
		<div class="col-md-12 row">
			<a href="?page=listing&id=<?php echo $row['postid'];?>" class="delete">Delete</a>
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
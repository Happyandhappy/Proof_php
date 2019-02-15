<div class="panel panel-default">
	<form method="post" enctype="multipart/form-data" id="form">
		<div class="panel-heading panel-default">
			<h4>Posting new article</h4>
		</div>
		<div class="panel-body">
			<input type="hidden" name="type" value="posting">
			<div class="form-group">
				<label for="content">Content</label>
				<textarea class="form-control" name="content" autocomplete="off" placeholder="Fill out Content"></textarea>
			</div>
			<div class="form-group">
				<label for="image">Images</label>
				<input type="file" class="form-control" name="files[]" id="files" autocomplete="off" accept="image/*" multiple>
			</div>
			<div class="alert alert-danger alert-dismissible hidden" id="alert">
				<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
				<p id="alert_content"></p>
			</div>
		</div>
		<div class="panel-footer">
			<button type="submit" class="btn btn-primary" id="load" data-loading-text="<i class='fa fa-spinner fa-spin '></i> Posting">Post Article
			</button>
		</div>
	</form>
</div>
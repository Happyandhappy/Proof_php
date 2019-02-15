<?php
	session_start();
	include "components/header.php";
	include "components/navbar.php";

	if (!isset($_SESSION['username']) ||!isset($_SESSION['userid'])){		
		header('Location: login.php');
		exit;
	}
?>
<div class="container">
	<div class="col-md-8 col-md-offset-2">
		<?php 
	    		if(isset($_GET['page']) and $_GET['page']=='listing')
	    			include("pages/listing.php");
	    		else
	    			include("pages/posting.php");
	    	?>
	</div>
</div>


<?php 
 include "components/footer.php";
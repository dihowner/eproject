
<!DOCTYPE html>
<html lang="en">
<head>
        <meta charset="utf-8" />
        <title>Market Place | Project Hub</title>
        <script src="assets/js/jquery-2.1.4.min.js"></script>
		<script src="assets/js/project.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.0/dist/sweetalert2.all.min.js"></script>
</head>
<body>
<?php
require "action.php"; $action = new Action();

if(isset($_REQUEST["fileID"])) {
	$d_url = $_REQUEST["fileID"];
	$chkDwnld = $action->query("select * from downloads where download_url='$d_url'"); $chkDwnld->execute();
	$chkDwnlds = $chkDwnld->fetch(PDO::FETCH_ASSOC);
	
	if(time() > strtotime($chkDwnlds["expires_on"])) { ?>
		<script>
			Swal.fire({
				title: "Url Expired",
				icon: "warning",
				text: "Download link has expired, kindly contact admin"
			}).then((reload) => {
				if(reload.isConfirmed) {
					window.location = "account/mydownload";
				}
			});
		</script>
	<?php } else {
		
		//Download begins...
		$materialInfo = $action->materialInfo($chkDwnlds["id"]);
		$fileName = $materialInfo["proj_doc"];
		$curr_downloads = $materialInfo["downloads"];
		$filepath = "uploads/".$fileName;
		
		if (file_exists($filepath)) {
			
			header('Content-Description: File Transfer');
			header('Content-Type: application/octet-stream');
			header('Content-Disposition: attachment; filename=' . basename($filepath));
			header('Expires: 0');
			header('Cache-Control: must-revalidate');
			header('Pragma: public');
			header('Content-Length: ' . filesize('uploads/' . $fileName));
			readfile('uploads/' . $fileName);
			
			//How many downloads do we have...
			$totaldwld = $curr_downloads + 1;
			
			//Update count...
			$updtDwnld = $action->query("update market set downloads='$totaldwld' where projectID='".$chkDwnlds["id"]."'"); $updtDwnld->execute();
			
		} else { ?>
		<script>
			Swal.fire({
				title: "Url Expired",
				icon: "warning",
				text: "Download link has expired, kindly contact admin"
			}).then((reload) => {
				if(reload.isConfirmed) {
					window.location = "account/mydownload";
				}
			});
		</script>
	<?php }
		
		// print_r($action->materialInfo($chkDwnlds["id"]));
	}
	
} else { ?>
	<script>
		Swal.fire({
			title: "Bad Url",
			icon: "warning",
			text: "Download link is required, kindly click on a valid download url"
		}).then((reload) => {
			if(reload.isConfirmed) {
				window.location = "account/mydownload";
			}
		});
	</script>
<?php } ?>


		
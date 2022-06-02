<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php
	  if(!is_null($_SESSION['data']['language'])){
  		include "./lang/".$_SESSION['data']['language'].".php";
		} 
	?>
	<title><?php echo $data['title'];?></title>
	<!-- <link href="https://fonts.googleapis.com/css?family=Noto+Sans" rel="stylesheet"> -->
	<link rel="stylesheet" type="text/css" href="<?php echo BASE_URL; ?>asset/bootstrap/css/bootstrap.min.css">
  <!-- <link rel="stylesheet" type="text/css" href="https://bootswatch.com/paper/bootstrap.min.css"> -->
	<link rel="stylesheet" type="text/css" href="<?php echo BASE_URL; ?>asset/css/metisMenu.min.css">
	<link rel="stylesheet" type="text/css" href="<?php echo BASE_URL; ?>asset/css/sb-admin-2.min.css">
	<link rel="stylesheet" type="text/css" href="<?php echo BASE_URL; ?>asset/fonts/css/font-awesome.min.css">
	
	<?php
		if(isset($data['css'])){
			foreach ($data['css'] as $css) {
				echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"".BASE_URL."asset/".$css."\">";
			}
		}
	?>
	<link rel="stylesheet" type="text/css" href="<?php echo BASE_URL; ?>asset/css/custom.css">
	<?php
	if(!is_null($_SESSION['data']['language'])){ ?>
			<link rel="stylesheet" type="text/css" href="<?php echo BASE_URL; ?>asset/css/<?php echo $_SESSION['data']['language']; ?>.css">
	<?php } ?>

	
	

</head>
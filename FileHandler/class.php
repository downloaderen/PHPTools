<?php
	require_once 'lib/WideImage.php';
	spl_autoload_register(function ($class) {
    	require_once 'classes/' . $class . '.php';
	});


	$imageDelete = new FileHandler([
		'folder' => './images',
		'imageName' => 'sad'
	]);
	$imageUploader = new FileUploader('imageUpload', './images/', 150, 150);
	$images = $imageDelete->getFiles();

	echo "<pre>", print_r(json_encode($imageDelete->getFiles())) ,"</pre>";

	if(isset($_POST['submit_image'])){
		$imageUpload = $imageUploader->init();
	}

	if(!empty($imageUpload['success'])){
		foreach ($imageUpload['success'] as $key => $value) {
			//gem i db = $value[1]
		}
	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
	<style type="text/css">
		*{
			margin: 0;
			padding: 0;
		}
		.fileManager{
			width: 100%;
			min-height: 100%;
		}
		.fileManager img{
			margin: 15px;
			float: left;
			border: 1px solid rgba(255, 155, 155, 0.4);
		}
		.fileManager .images{
			width: 30%;
			float: left;
			display: flex;
			align-items: center;
			margin: 1.65%;
			-webkit-box-shadow: 0px 0px 8px 1px rgba(133,133,133,1);
			-moz-box-shadow: 0px 0px 8px 1px rgba(133,133,133,1);
			box-shadow: 0px 0px 8px 1px rgba(133,133,133,1);
		}
		.fileManager p{
			line-height: 20px;
		}
	</style>
</head>
<body>
	<form action="" method="post" enctype="multipart/form-data">
		<input type="file" multiple name="imageUpload[]"><br />
		<button name="submit_image" type="submit">Upload</button>
	</form>
	<?php
		//error beskeder
		if(!empty($imageUpload['errors'])){
			$msg = 'Følgende billede(r) kun ikke uploades:';
			foreach ($imageUpload['errors'] as $key => $value) {
				if(isset($value[0]) && $value[0] == 1){
					$msg .= "<br />{$key}";
				}
				if(isset($value[3]) && $value[3] == 1){
					$msg = "Du skal vælge et billede eller flere!";
				}
			}
			echo $msg;
		}

		//success beskeder
		if(!empty($imageUpload['success'])){
			$msg = 'Følgende billede(r) blev uploadet:';
			foreach ($imageUpload['success'] as $key => $value) {
				$msg .= "<br />{$value[1]}";
			}
			echo $msg;
		}
	?>

	<div class="fileManager">
		<?php foreach ($images as $key => $value): ?>
			<div class="images">
				<img src="<?= $value['thumb'] ?>">
				<p>
					Original: <?= $value['srcSize'] ?><br />
					Thumb: <?= $value['thumbSize'] ?>
				</p>
			</div>
		<?php endforeach ?>
	</div>
</body>
</html>
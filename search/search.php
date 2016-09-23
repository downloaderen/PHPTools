<?php
	require_once 'config.php';

	$searchAll = isset($_GET['searchAll']) && $_GET['searchAll'] != '' ? "LIKE '%". $_GET['searchAll'] . "%'" : null;

	$category = isset($_GET['category']) && $_GET['category'] != '' ? '='. $_GET['category'] : "!= 'null'";
	$model = isset($_GET['model']) && $_GET['model'] != '' ? '='. $_GET['model'] : "!= 'null'";
	$price = isset($_GET['price']) && $_GET['price'] != '' ? '<='. $_GET['price'] : "!= 'null'";
	$search = isset($_GET['search']) && $_GET['search'] != '' ? "LIKE '%". $_GET['search'] . "%'" : "!= 'null'";

	$searchInput = isset($_GET['search']) && $_GET['search'] != '' ? $_GET['search'] : '';
	$priceInput = isset($_GET['price']) && $_GET['price'] != '' ? $_GET['price'] : '';
	$categorySelect = isset($_GET['category']) && $_GET['category'] != '' ? $_GET['category'] : '';
	$modelSelect = isset($_GET['model']) && $_GET['model'] != '' ? $_GET['model'] : '';


?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
</head>
<body>
	<form method="get">
		<select name="category">
			<option value="">Vælg Kategori</option>
			<?php
				// et eksempel på et udtræk
				$sql = "SELECT * FROM `category`";
				$result = mysqli_query($conn, $sql);

				while($row = mysqli_fetch_assoc($result)){
			    	if($categorySelect == $row['id']){
			    		echo '<option selected value="'.$row['id'].'">'.$row['name'].'</option>';
			    	} else {
			    		echo '<option value="'.$row['id'].'">'.$row['name'].'</option>';
			    	}
			    }
		?>
		</select>
		<select name="model">
			<option value="">Vælg Producent</option>
		<?php
				// et eksempel på et udtræk
				$sql = "SELECT * FROM `models`";
				$result = mysqli_query($conn, $sql);

				while($row = mysqli_fetch_assoc($result)){
					if($modelSelect == $row['id']){
			    		echo '<option selected value="'.$row['id'].'">'.$row['name'].'</option>';
			    	} else {
			    		echo '<option value="'.$row['id'].'">'.$row['name'].'</option>';
			    	}
			    }
		?>
		</select>
		<input type="number" name="price" value="<?= $priceInput ?>">
		<input type="text" name="search" value="<?= $searchInput ?>">
		<button type="submit">Søg</button>
	</form>
	<div>
		<?php
			if($searchAll != null){
				// et eksempel på et udtræk
				$sql = "SELECT products.id,
						products.name,
						products.price,
						models.name AS modelName,
						category.name AS categoryName
						FROM `products`
						INNER JOIN category ON products.fkCategoryId = category.id
						INNER JOIN models ON products.fkModelId = models.id
						WHERE models.name $searchAll
						OR category.name $searchAll
						OR products.name $searchAll";
			} else{
				// et eksempel på et udtræk
				$sql = "SELECT products.id,
						products.name,
						products.price,
						models.name AS modelName,
						category.name AS categoryName
						FROM `products`
						INNER JOIN category ON products.fkCategoryId = category.id
						INNER JOIN models ON products.fkModelId = models.id
						WHERE models.id $model
						AND category.id $category
						AND products.price $price
						AND products.name $search";
			}
			$result = mysqli_query($conn, $sql);

			while($row = mysqli_fetch_assoc($result)){
		    	echo $row['name'];
		    	echo '<br>' . $row['price'];
		    }
		?>
	</div>
</body>
</html>
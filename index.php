<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Storage</title>
	<link rel="stylesheet" type="text/css" href="./style/css/style.css">
</head>
<body>
	<nav></nav>

	<header>
		<button id="add" class="button">ДОБАВИТЬ</button>
		<form class="button" method="post" action="">
			<select name="table_name" id="table_name" onchange="this.form.submit()">
				<option value="" name="first_element" id="first_element" disabled></option>
				<option value="отладочная">отладочная</option>
				<option value="ед_изм">ед_изм</option>
				<option value="категория">категория</option>
			</select>
		</form>
		<button id="remove" class="button">УДАЛИТЬ</button>
	</header>
	<main>
		<div id="scroller">
			<!-- DATA -->
		</div>
	</main>

	<script src="style/js/script.js"></script>
	<?php include 'source/init.php'; ?>
</body>
</html>

<?php

$table_name = ($_POST["table_name"] == null) ? "отладочная" : $_POST["table_name"];
echo '<script>
	document.getElementById(`first_element`).innerHTML = `'. $table_name .'`;
</script>';

echo '<script>
	var scroller = document.getElementById(`scroller`);
	scroller.innerHTML = `'. Output::get_table_cols($table_name) .'`;
	scroller.innerHTML += `'. Output::get_table_data($table_name) .'`;
</script>';

?>
<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Storage</title>
	<link rel="stylesheet" type="text/css" href="/style/css/mystyle.css">
</head>
<body>
	<nav></nav>

	<header>
		<button id="add" class="button">ДОБАВИТЬ</button>
		<form id="select_form" method="post" action="">
			<select name="table_name" id="table_name" onchange="this.form.submit()">
				<option value="" name="first_element" id="first_element"></option>
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

$tables = Input::exec_tr("SELECT TABLE_NAME FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA='CatalogDB';");
foreach ($tables as $name) {
    echo '<script>
		document.querySelector(`#table_name`).innerHTML += `<option value="'. $name['TABLE_NAME'] .'">'. $name['TABLE_NAME'] .'</option>`;
	</script>';
}

//		table's data
$table_name = ($_POST["table_name"] == null) ? "ЕД_ИЗМ" : $_POST["table_name"];
echo '<script>
	document.querySelector(`#first_element`).innerHTML = `'. strtoupper($table_name) .'`;
</script>';

echo '<script>
	var scroller = document.querySelector(`#scroller`);
	scroller.innerHTML = `'. Output::get_table_cols($table_name) .'`;
	scroller.innerHTML += `'. Output::get_table_data($table_name) .'`;
</script>';

?>
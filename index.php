<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Storage</title>
	<link rel="stylesheet" type="text/css" href="/style/css/style.css?modified=12">
</head>
<body>
	<header>
		<button type="button" id="add" class="button" onclick="display_add_form()">ДОБАВИТЬ</button>
		<form method="POST" action="" id="select_form">
			<select name="table_name" id="table_name" onchange="this.form.submit()">
				<!-- OPTIONS -->
			</select>
		</form>
		<button type="button" id="remove" class="button" onclick="display_rem_form();">УДАЛИТЬ</button>
	</header>
	<main>
		<div id="scroller">
			<!-- DATA -->
		</div>
	</main>

	<form method="POST" action="" id="add_form" name="add_form">
		<!-- INPUTS -->
    </form>

	<form method="POST" action="" id="rem_form" name="rem_form">
		<!-- DATA -->
	</form>

	<div id="notice_window"></div>

	<?php	include_once  'source/init.php';
			include_once  'source/load.php';update_table();	?>
	<script src="style/js/script.js?modified=4"></script>
</body>
</html>
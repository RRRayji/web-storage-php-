<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Storage</title>
	<link rel="stylesheet" type="text/css" href="/style/css/style.css?modified=25">
</head>
<body>
	<header>
		<button type="button" id="add" class="button" onclick="display_add_form()">ДОБАВИТЬ</button>
		<input type="search" id="search" class="button" placeholder="поиск" minlength="2" onkeydown="search(event)">
		<form method="POST" action="" id="select_form">
			<select name="table_name" id="table_name" onchange="this.form.submit()">
				<!-- OPTIONS -->
			</select>
		</form>
		<input type="button" class="button" value="ПЕЧАТЬ" onclick="myPrint()">
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

	<form method="POST" action="" id="edit_form" name="edit_form">
		<input type="hidden" id="edit_table" name="a_table_name">
		<input type="hidden" id="edit_id_name" name="edit_id_name">
		<input type="hidden" id="edit_id" name="edit_id">
		<input type="hidden" id="edit_column" name="edit_column">
		<input type="hidden" id="edited_value" name="edited_value">
		<input type="hidden" id="new_value" name="new_value">
		<input type="submit" id="edit_button" name="edit_button" value="✓">
	</form>

	<div id="notice_window"></div>

	<?php	include_once  'source/init.php';
			include_once  'source/load.php';update_table();	?>
	<script src="style/js/script.js?modified=27"></script>
</body>
</html>
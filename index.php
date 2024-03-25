<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Storage</title>
	<link rel="stylesheet" type="text/css" href="/style/css/style.css?modified=39">
</head>
<body>
	<header>
		<button type="button" id="add" class="button" onclick="display_add_form()">ДОБАВИТЬ</button>
		<input type="search" id="search" class="button" placeholder="поиск" minlength="1" onkeydown="search(event)">
		<form method="POST" action="" id="query_form">
			<select id="select_query" name="select_query" onchange="display_fromto_form()">
				<option value="" selected>ЗАПРОСЫ</option>
				<option value="dates">ПРИХОД С-ПО</option>
				<option value="rashod">РАСХОД С-ПО</option>
				<option value="finance">ФИНАНСЫ (ЗА МЕСЯЦ)</option>
				<option value="top10">ТОП 10 ПРОДАЖ</option>
				<option value="categ_rep">ОТЧЁТ ПО КАТЕГОРИЯМ</option>
			</select>
			<div id="fromto_form">
				<input type="date" class="add_input" name="from">
				<input type="date" class="add_input" name="to">
				<input type="submit" class="add_input" name="ft_confirm_button" value="НАЙТИ">
			</div>
			<div id="rashod_form">
				<input type="date" class="add_input" name="r_from">
				<input type="date" class="add_input" name="r_to">
				<input type="submit" class="add_input" name="rashod_button" value="НАЙТИ">
			</div>
			<div id="finance">
				<input type="date" class="add_input" name="month">
				<input type="submit" class="add_input" name="fin_confirm_button" value="НАЙТИ">
			</div>
			<input type="submit" class="hidden-input" id="top10_button" name="top10_button" value="" onclick="this.form.submit()">
			<input type="submit" class="hidden-input" id="categ_rep_button" name="categ_rep_button" value="" onclick="this.form.submit()">
		</form>
		<form method="POST" action="" id="select_form">
			<select name="table_name" id="table_name" onchange="this.form.submit()">
				<!-- OPTIONS -->
			</select>
		</form>
		<input type="button" class="button" value="ПЕЧАТЬ" onclick="myPrint()">
		<button type="button" id="remove" class="button" onclick="display_rem_form()">УДАЛИТЬ</button>
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
			include_once  'source/load.php';	?>
	<script src="style/js/script.js?modified=45"></script>
</body>
</html>
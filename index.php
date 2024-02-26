<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Storage</title>
	<!-- <link rel="stylesheet" type="text/css" href="./style/css/style.css"> -->
	<style>
		*{
			margin: 0;
			padding: 0;
		}
		body, html {
			min-height: 420px;
		}
		::-webkit-scrollbar{
			width: 1svw;
			max-width: 8px;
			height: 10px;
		}
		::-webkit-scrollbar-track{
			background-color: #06070d;
		}
		::-webkit-scrollbar-track-piece{
			background-color: #242426;
		}
		::-webkit-scrollbar-thumb{
			height: 50px; background-color: #596066; border-radius: 3px;
		}
		::-webkit-scrollbar-thumb:hover{
			background-color: rgba(89, 96, 102, .7);
		}
		::-webkit-scrollbar-corner{
			background-color: #06070d;
		}
		::-webkit-resizer{
			background-color: #596066;
		}
		@font-face{
			font-family: 'JetBrains Mono';
			src: url('/style/fonts/JetBrainsMono-SemiBold.ttf') format('truetype');
		}
		header{
			margin: 3svh 2svw 0;
			min-height: 45px;
			min-width: 570px;
			height: 5svh;
			border-radius: 20px 20px 0 0;
			display: flex;
			justify-content: center;
			align-items: center;
			background-color: #778da9;
		}
		.button{
			width: 15%;
			min-width: 120px;
			height: 100%;
			display: flex;
			justify-content: center;
			align-items: center;
			font: 16px Luminari, fantasy;
			letter-spacing: 1.3px;
			text-decoration: none;
			border: none;
			cursor: pointer;
			color: #e0e1dd;
			background-color: #415a77;
		}
		.button:first-child{
			border-radius: 20px 0 0 20px;
		}
		.button:last-child{
			border-radius: 0 20px 20px 0;
		}
		.button:hover{
			-webkit-transition: .5s all;
			-moz-transition: .5s all;
			-ms-transition: .5s all;
			transition: .5s all;
			opacity: 0.5;
		}
		#table_name{
			color: #e0e1dd;
			background-color: #415a77;
		}
		main{
			display: flex;
    		justify-content: center;
			border-radius: 0 0 20px 20px;
			margin: 0 2svw 3svh;
			min-height: 400px;
			min-width: 570px;
			max-height: 89svh;		/*	100-3-5-2-(1?)	*/
			overflow: hidden;
			background-color: #1b2d37;
		}
		#scroller{
			width: 30svw;
			min-width: 300px;
			overflow: auto;
		}
		.row{
			display: flex;
			flex-wrap: nowrap;
			align-items: center;
			justify-content: center;
			min-height: 30px;
			height: 5svh;
		}
		/*.row:first-child{						to finalize
			max-height: 5svh;
		}*/
		.row:last-child{
			border-radius: inherit;
		}
		.cell{
			display: flex;
			align-items: center;
			justify-content: center;
			font-family: 'JetBrains Mono', monospace;
			font-size: 14px;
			min-height: 100%;
			min-width: 50px;
			width: 33.333333%;									/* dynamic */
			color: #e0e1dd;
			background-color: #415a77;
		}
		.row:nth-child(odd) .cell{
			background-color: #778da9;
		}
		.cell:first-child{
			border-radius: inherit;
			border-bottom-right-radius: 0;
		}
		.cell:last-child{
			border-radius: inherit;
			border-bottom-left-radius: 0;
		}
	</style>
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
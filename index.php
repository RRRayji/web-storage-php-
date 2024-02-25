<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Hand-made Catalog</title>
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
			background-color: darkcyan;
			min-height: 45px;
			min-width: 570px;
			height: 5svh;
			border-radius: 20px 20px 0 0;
			display: flex;
			justify-content: center;
			align-items: center;
		}
		.button{
			width: 15%;
			height: 100%;
			background-color: #33a4a4;
			display: flex;
			justify-content: center;
			align-items: center;
			font: 16px Luminari, fantasy;
			color: rgb(16, 109, 109);/* rgb(82, 136, 138); */
			letter-spacing: 1.3px;
			text-decoration: none;
			border: none;
			cursor: pointer;
		}
		.button:nth-of-type(2n){
			background-color: #2fadad;
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
		main{
			display: flex;
    		justify-content: center;
			background-color: rgb(48, 61, 61);
			border-radius: 0 0 20px 20px;
			margin: 0 2svw 3svh;
			min-height: 400px;
			min-width: 570px;
			max-height: 89svh;		/*	100-3-5-2-(1?)	*/
			overflow: hidden;
		}
		#scroller{
			width: 30svw;
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
			background-color: rgb(8, 124, 124);
		}
		.cell:first-child{
			border-radius: inherit;
			border-bottom-right-radius: 0;
		}
		.cell:last-child{
			border-radius: inherit;
			border-bottom-left-radius: 0;
		}
		.row:nth-child(odd) .cell:nth-child(even),
		.row:nth-child(even) .cell:nth-child(odd) {
			background-color: rgb(8, 100, 100);
		}
	</style>
</head>
<body>
	<nav></nav>

	<header>
		<button id="add" class="button">ДОБАВИТЬ</button>
		<form class="button" method="post" action="">
			<button id="table_name" name="table_name" class="button">НАЗВАНИЕ ТАБЛИЦЫ</button>
		</form>
		<button id="remove" class="button">УДАЛИТЬ</button>
	</header>
	<main>
		<div id="scroller">
			<div class="row">
				<div class="cell">ид</div>
				<div class="cell">значение</div>
				<div class="cell">ед_изм</div>
			</div>
			<div class="row">
				<div class="cell">1</div>
				<div class="cell">10</div>
				<div class="cell">л</div>
			</div>
			<div class="row">
				<div class="cell">2</div>
				<div class="cell">15</div>
				<div class="cell">кг</div>
			</div>
		</div>
	</main>
	
	<script src="style/js/script.js"></script>
	<?php include 'source/init.php'; ?>
</body>
</html>

<?php

$table_name = $_POST['table_name'];
#echo "'" . $table_name . "'";
echo '<script>
	var scroller = document.getElementById(`scroller`);
	scroller.innerHTML = `'. Output::get_table_cols("отладочная") .'`;
	scroller.innerHTML += `'. Output::get_table_data("отладочная") .'`;
</script>';

?>
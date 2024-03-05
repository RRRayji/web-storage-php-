<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Storage</title>
	<!-- <link rel="stylesheet" type="text/css" href="/style/css/mystyle.css"> -->
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
			src: url('style/fonts/JetBrainsMono-SemiBold.ttf') format('truetype');
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
			opacity: 0.7;
		}
		#select_form{
			width: 15%;
			min-width: 120px;
			height: 100%;
		}
		#table_name{
			text-align: center;
			width: 100%;
			height: inherit;
			font: 16px Luminari, fantasy;
			letter-spacing: 1.3px;
			text-decoration: none;
			outline: none;
			border: none;
			cursor: pointer;
			color: #e0e1dd;
			background-color: #415a77;
		}
		#table_name:hover{
			border: 1px solid #778da9;
		}
		select#table_name option{
			cursor: pointer;
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
			border: 1px solid #1b2d37;
			min-width: 300px;
			overflow: auto;
		}
		.row{
			display: flex;
			flex-wrap: nowrap;
			overflow: hidden;
			align-items: flex-start;
			justify-content: center;
			min-height: 30px;
			height: 5svh;
			border-top: 1px solid #1b2d37;
		}
		.row:first-child{
			border-top: none;
		}
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
			overflow: hidden;
			padding: 0 5px;
			border-right: 1px solid #1b2d37;
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
		.text{
			justify-content: left;
		}
		/* 			ADD FORM		 */
		#add_form{
			display: none;
			position: absolute;
			left: 25.5svw;
			min-height: 17svh;
			min-width: 230px;
			padding: 3svh 2svw;
			border-radius: 15px;
			border: 1px solid #415a77;
			background-color: #1b2d37;
		}
		.add_input{
			margin: 1.5svh 0 0;
			min-width: 13svw;
			min-height: 3.5svh;
			max-height: 5svh;
			border-radius: 10px;
			padding: 0 10px;
			font-family: 'JetBrains Mono', monospace;
			font-size: 14px;
			letter-spacing: 1px;
			background-color: #edf2f4;
			border: 2px solid #415a77;
		}
		.add_input:first-child{
			margin: 0;
		}
		.add_input:last-child{
			min-width: 10svw;
			margin: 1.5svh 3svw 0;
			cursor: pointer;
			color: #e0e1dd;
			background-color: #415a77;
		}
		.add_input:last-child:hover{
			-webkit-transition: .5s all;
			-moz-transition: .5s all;
			-ms-transition: .5s all;
			transition: .5s all;
			opacity: 0.8;
		}
	</style>
</head>
<body>
	<header>
		<button type="button" id="add" class="button" onclick="display_add_form()">ДОБАВИТЬ</button>
		<form method="POST" action="" id="select_form">
			<select name="table_name" id="table_name" onchange="this.form.submit()">
				<!-- OPTIONS -->
			</select>
		</form>
		<button type="button" id="remove" class="button">УДАЛИТЬ</button>
	</header>
	<main>
		<div id="scroller">
			<!-- DATA -->
		</div>
	</main>

	<form method="POST" action="" id="add_form" name="add_form">
		<input type="hidden" id="a_table_name" name="a_table_name" value="ПОСТАВЩИК">
		<!-- INPUTS -->
    </form>

	<script src="/style/js/myscript.js"></script>
	<?php	include 'source/init.php';
			include 'source/load.php';	?>
</body>
</html>
<?php

function to_upper($string)
{
	return mb_convert_case($string, MB_CASE_UPPER, "UTF-8");
}

//		names of tables
$tables = Input::exec_tr("SELECT TABLE_NAME FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA='CatalogDB';");
foreach ($tables as $name) {
    echo '<script>
		document.querySelector(`#table_name`).innerHTML += `<option value="'. to_upper($name['TABLE_NAME']) .'">'. to_upper($name['TABLE_NAME']) .'</option>`;
	</script>';
}

//		current table's data
$table_name = ($_POST["table_name"] == null) ? "ЕД_ИЗМ" : $_POST["table_name"];
echo '<script>
	document.querySelector(`#first_element`).innerHTML = `'. to_upper($table_name) .'`;
</script>';

echo '<script>
	var scroller = document.querySelector(`#scroller`);
	scroller.innerHTML = `'. Output::get_table_cols($table_name) .'`;
	scroller.innerHTML += `'. Output::get_table_data($table_name) .'`;
</script>';

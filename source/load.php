<?php
function to_upper($string)
{
	return mb_convert_case($string, MB_CASE_UPPER, "UTF-8");
}


//		names of tables
$tables = Input::exec_tr("SELECT TABLE_NAME FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA='CatalogDB';");
foreach ($tables as $name) {
    echo '<script>
		document.querySelector(`#table_name`).innerHTML += `<option>'. to_upper($name['TABLE_NAME']) .'</option>`;
	</script>';
}


//		current table's data
$table_name = ($_POST["table_name"] == null) ? "ПОСТАВЩИК" : $_POST["table_name"];
echo '<script>
	document.querySelector(`#first_element`).innerHTML = `'. to_upper($table_name) .'`;
</script>';

echo '<script>
	var scroller = document.querySelector(`#scroller`);
	scroller.innerHTML = `'. Output::get_table_cols($table_name) .'`;
	scroller.innerHTML += `'. Output::get_table_data($table_name) .'`;
</script>';


//		add form
echo '<script>
	document.querySelector("#add_form").innerHTML += `<input type="hidden" id="a_table_name" name="a_table_name" value="ПОСТАВЩИК">`;
</script>';
foreach (Output::get_cols($table_name) as $cell) {
    echo '<script>
		document.querySelector("#add_form").innerHTML += `<input type="text" class="add_input" id="'. $cell .'" name="'. $cell .'" placeholder="'. $cell .'" required>`;
	</script>';
}
echo '<script>
	document.querySelector("#add_form").innerHTML += `<input type="submit" class="add_input" id="добавить" name="добавить" value="ДОБАВИТЬ">`;
</script>';

if (isset($_POST["добавить"]))
{
	// something new...
}
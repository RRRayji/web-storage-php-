<?php
$DB_NAME = "копеечка";
$table_name = "состав_накладной";
$id_name = "ид";
$NODATAERR = "Ошибка значения.";
$pk_is_ai = false;
$fk_table = array();


function is_in_array($value, $key, $array)
{
	foreach ($array as $el)
	{
		if (strtolower($el[$key]) == $value) return true;
	}
	return false;
}

function is_varchar($selected_col)
{
	global $table_name;
	$query = "SELECT DATA_TYPE FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME='" . $table_name . "' AND COLUMN_NAME='" . $selected_col . "';";
	$res = Input::exec_tr($query);
	return strtolower($res[0]["DATA_TYPE"]) == "varchar";
}

function to_upper($string)
{
	return mb_convert_case($string, MB_CASE_UPPER, "UTF-8");
}

function dis($string)
{
	echo '<script>alert(`'. $string .'`)</script>';
}

function update_table($load_current = null)
{
	global $DB_NAME;
	global $table_name;
	global $id_name;
	global $pk_is_ai;
	global $fk_table;

    // Получение списка таблиц
	echo '<script>
		document.querySelector(`#table_name`).innerHTML = `<option value="" name="first_element" id="first_element"></option>`;
	</script>';
    $tables = Input::exec_tr("SELECT TABLE_NAME FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA='".$DB_NAME."';");
    foreach ($tables as $name) {
        echo '<script>
            document.querySelector(`#table_name`).innerHTML += `<option value="'. $name['TABLE_NAME'] .'">'. to_upper($name['TABLE_NAME']) .'</option>`;
        </script>';
    }

    // Обновление текущих данных таблицы
	if (!empty($load_current))
	{
		$table_name = $load_current;
	}
	else if (($_POST["table_name"] != null))
	{
		$table_name = $_POST["table_name"];
	}
    echo '<script>
        document.querySelector(`#first_element`).innerHTML = `'. to_upper($table_name) .'`;
    </script>';

    echo '<script>
        var scroller = document.querySelector(`#scroller`);
        scroller.innerHTML = `'. Output::get_table_cols($table_name) .'`;
        scroller.innerHTML += `'. Output::get_table_data($table_name) .'`;
    </script>';

    // упд скрытых полей форм
    echo '<script>
		document.querySelector("#add_form").innerHTML = `<input type="hidden" id="a_table_name" name="a_table_name" value="'. $table_name .'">`;
	</script>';
	
	//	INIT ID
	$id_name = Input::exec_tr("SELECT COLUMN_NAME,EXTRA FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME='". $table_name ."' AND COLUMN_KEY='PRI';");
	if (is_in_array("auto_increment", 'EXTRA', $id_name)) $pk_is_ai = true;
	$id_name = $id_name[0]['COLUMN_NAME'];

	$index_cols = Input::exec_tr("SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = '". $table_name ."' AND COLUMN_KEY='MUL';");
	foreach (Output::get_cols($table_name) as $col)
	{
		if ($pk_is_ai && $col == $id_name)
		{
			echo '<script>
				document.querySelector("#add_form").innerHTML += `<input type="hidden" id="pk_id" name="pk_id" value="'. $col .'">`;
			</script>';
			continue;
		}
		if (is_in_array($col, 'COLUMN_NAME', $index_cols))
		{
			echo '<script>
				document.querySelector("#add_form").innerHTML += `<input type="hidden" id="'. $col .'" name="'. $col .'" value="'. $col .'">`;
				document.querySelector("#add_form").innerHTML += `<select class="add_input" id="select_'.$col.'" name="select_'.$col.'"></select>`;
				document.querySelector("#select_'.$col.'").innerHTML = `<option class="add_options" disabled>'.$col.'</option>`;
			</script>';

			$ref_tab = Input::exec_tr("SELECT REFERENCED_COLUMN_NAME, REFERENCED_TABLE_NAME FROM information_schema.KEY_COLUMN_USAGE WHERE TABLE_NAME = '".$table_name."' AND COLUMN_NAME='".$col."';");
			$ref_col = $ref_tab[0]["REFERENCED_COLUMN_NAME"];
			$ref_tab = $ref_tab[0]["REFERENCED_TABLE_NAME"];
















			/*			визуальное представление данных, принимаемых посредством input::exec_tr()
			foreach ($fk_table as $v => $c)
			{
				print_r($fk_table[$v][$id_name] . " : " . $c[$second_column]);
				echo "<br>";
			}					поиск array_search("кг.", $fk_table)
			
			foreach ($fk_table_buff as $row)
			{
				$fk_table[$row[$id_name]] = $row[$second_column];
				echo '<script>
					document.querySelector("#select_'.$col.'").innerHTML += `<option class="add_options">'.$row[$second_column].'</option>`;
				</script>';
			}
			*/
		}
		else
		{
			$type = (is_varchar($col)) ? "text" : "number";
			echo '<script>
				document.querySelector("#add_form").innerHTML += `<input type="'.$type.'" class="add_input" id="'. $col .'" name="'. $col .'" placeholder="'. $col .'" required>`;
			</script>';
		}
	}
	echo '<script>
		document.querySelector("#add_form").innerHTML += `<input type="submit" class="add_input" id="добавить" name="добавить" value="ДОБАВИТЬ">`;
	</script>';
	echo '<script>
		document.querySelector("#rem_form").innerHTML = `<div id="confirm_text">ВЫ УВЕРЕНЫ?</div>
			<input type="hidden" id="a_table_name" name="a_table_name" value="'. $table_name .'">
			<input type="hidden" id="selected_class" name="selected_class" value="">
			<input type="hidden" id="selected_value" name="selected_value" value="">
			<input type="submit" id="rem_confirm" name="rem_confirm" value="ДА">
		`;
	</script>';
}

update_table();


function is_inputs_valid()
{
	global $table_name;
	global $id_name;
	global $pk_is_ai;

	$id_name = Input::exec_tr("SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME='". $table_name ."' AND COLUMN_KEY='PRI';");
	$id_name = $id_name[0]['COLUMN_NAME'];
	//										print_r($table_name . "<br>" . $id_name);
	
	foreach (Output::get_cols($table_name) as $col)
    {
		if ($pk_is_ai && $col == $id_name) continue;
		$s = trim($_POST[$col]);
        if (empty($s)) return true;
    }
	return false;
}
if (isset($_POST["добавить"]))
{
    $table_name = $_POST["a_table_name"];

	if (is_inputs_valid())
	{
		dis($NODATAERR);
	}
	else
	{
		$query = "INSERT INTO " . $table_name . "(";
	
		$columns = "";
		$values = "";
		foreach (Output::get_cols($table_name) as $col)
		{
			if ($pk_is_ai && $col == $id_name) continue;
			$columns .= $col . ", ";
			$values .= (is_varchar($col)) ? "'" . $_POST[$col] . "', " : $_POST[$col] . ", ";
		}
		$columns = rtrim($columns, ", ");
		$values = rtrim($values, ", ");
	
		$query .= $columns . ") VALUES(" . $values . ");";
		Input::execonly_tr($query);
	}
	update_table($table_name);
}

if (isset($_POST["rem_confirm"]))
{
	$table_name = $_POST["a_table_name"];
	$selected_col = $_POST["selected_class"];
	$selected_value = $_POST["selected_value"];
	if (empty($table_name) || empty($selected_col) || empty($selected_value))
	{
		dis($NODATAERR);
	}
	else
	{
		if (is_varchar($selected_col)) $selected_value = "'" . $selected_value . "'";
		$query = "DELETE FROM " . $table_name . " WHERE " . $selected_col . " = " . $selected_value . ";";
		Input::execonly_tr($query);
	}
	update_table($table_name);
}
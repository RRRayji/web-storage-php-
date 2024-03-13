<?php
$DB_NAME = "test";
$table_name = "заявка";
$ID_NAME = "ид";
$NODATAERR = "Ошибка значения.";
$is_auto_increment = false;


function is_in_array($value, $key, $array)
{
	foreach ($array as $el)
	{
		if (strtolower($el[$key]) == $value) return true;
	}
	return false;
}

function is_varchar($table_name, $selected_col)
{
	$query = "SELECT DATA_TYPE FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA='". $DB_NAME ."' AND TABLE_NAME='" . $table_name . "' AND COLUMN_NAME='" . $selected_col . "';";
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
	global $table_name;
	global $DB_NAME;
	global $ID_NAME;
	global $is_auto_increment;

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
	// Проверка, является ли поле 'ид' с автоинкрементом
	$id_extras = Input::exec_tr("SELECT EXTRA FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = '". $table_name ."' AND COLUMN_KEY= 'PRI';");
	if (is_in_array("auto_increment", 'EXTRA', $id_extras)) $is_auto_increment = true;

	$index_cols = Input::exec_tr("SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = '". $table_name ."' AND COLUMN_KEY = 'MUL';");

	foreach (Output::get_cols($table_name) as $cell)
	{
		if ($is_auto_increment && $cell == $ID_NAME) continue;
		if (is_in_array($cell, 'COLUMN_NAME', $index_cols))
		{
			echo '<script>
				document.querySelector("#add_form").innerHTML += `<input type="hidden" class="add_input" id="'. $cell .'" name="'. $cell .'" placeholder="'. $cell .'">`;
				document.querySelector("#add_form").innerHTML += `<select class="add_input" id="select_'.$cell.'"></select>`;
				document.querySelector("#select_'.$cell.'").innerHTML = `<option class="add_options" value="select_'.$cell.'" disabled>'.$cell.'</option>`;
			</script>';
			$fk_table = Input::exec_tr("SELECT ид,наименование FROM ". preg_replace('/^ид-/', '', $cell) .";");
			foreach ($fk_table as $row)
			{
				echo '<script>
					document.querySelector("#select_'.$cell.'").innerHTML += `<option class="add_options" value="select_'.$row['наименование'].'">'.$row['наименование'].'</option>`;
				</script>';
			}
		}
		else
		{
			echo '<script>
				document.querySelector("#add_form").innerHTML += `<input type="text" class="add_input" id="'. $cell .'" name="'. $cell .'" placeholder="'. $cell .'" required>`;
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


function is_inputs_empty()
{
	global $table_name;
	global $ID_NAME;
	global $is_auto_increment;

	foreach (Output::get_cols($table_name) as $cell)
    {
		if ($is_auto_increment && $cell == $ID_NAME) continue;
		$s = trim($_POST[$cell]);
        if (empty($s)) return true;
    }
	return false;
}

if (isset($_POST["добавить"]))
{
    $table_name = $_POST["a_table_name"];
	if (is_inputs_empty())
	{
		dis($NODATAERR);
	}
	else
	{
		$query = "INSERT INTO " . $table_name . "(";
	
		$columns = "";
		$values = "";
		foreach (Output::get_cols($table_name) as $cell)
		{
			if ($is_auto_increment && $cell == $ID_NAME) continue;
			$columns .= $cell . ", ";
			$values .= (is_varchar($table_name, $cell)) ? "'" . $_POST[$cell] . "', " : $_POST[$cell] . ", ";
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
		if (is_varchar($table_name, $selected_col)) $selected_value = "'" . $selected_value . "'";
		$query = "DELETE FROM " . $table_name . " WHERE " . $selected_col . " = " . $selected_value . ";";
		Input::execonly_tr($query);
	}
	update_table($table_name);
}
<?php
$DB_NAME = "копеечка";
$table_name = "товары";
$NODATAERR = "Ошибка: введите валидное значение.";
$pk_is_ai = false;
$index_cols = array();
$tables = Input::exec_tr("SELECT TABLE_NAME FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA='".$DB_NAME."';");

function find_next($column, $table)
{
	$buff_arr = array();
	for ($i = 0; $i < count($table); ++$i)
	{
		$buff_arr[] = $table[$i]['COLUMN_NAME'];
	}
	$id = array_search($column, $buff_arr)+1;
	return $buff_arr[($id >= count($buff_arr) ? ($id - 2) : $id)];
}

function is_in_array($value, $key, $array)
{
	foreach ($array as $el)
	{
		if (strtolower($el[$key]) == strtolower($value)) return true;
	}
	return false;
}

function is_varchar($selected_col)
{
	global $table_name;
	$query = "SELECT DATA_TYPE FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME='" . $table_name . "' AND COLUMN_NAME='" . $selected_col . "';";
	$res = Input::exec_tr($query);
	return (strtolower($res[0]["DATA_TYPE"]) == "varchar" || strtolower($res[0]["DATA_TYPE"]) == "date");
}

function convert_sql_datatype($selected_col)
{
	global $table_name;
	$query = "SELECT DATA_TYPE FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME='" . $table_name . "' AND COLUMN_NAME='" . $selected_col . "';";
	$res = Input::exec_tr($query);
	$type = strtolower($res[0]["DATA_TYPE"]);
	if ($type == "varchar") return "text";
	else if ($type == "int") return "number\" min=\"1\"";
	else return "date";
}

function to_upper($string)
{
	return mb_convert_case($string, MB_CASE_UPPER, "UTF-8");
}

function dis($string)
{
	echo '<script>alert(`'. $string .'`)</script>';
}

function update_table($args = null)
{
	if (!empty($args['notice']))
	{
		echo '<script>
			window.addEventListener("load", function eventHandler(){
				notify("'.$args['notice'].'");
				this.removeEventListener("load", eventHandler);
			});
		</script>';
	}
	global $DB_NAME;
	global $table_name;
	global $pk_is_ai;
	global $index_cols;

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
	if (!empty($args['table']))
	{
		$table_name = $args['table'];
	}
	else if (($_POST["table_name"] != null))
	{
		$table_name = $_POST["table_name"];
	}
    echo '<script>
        document.querySelector(`#first_element`).innerHTML = `'. to_upper($table_name) .'`;
    </script>';

    echo '<script>
        document.querySelector(`#scroller`).innerHTML = `'. Output::get_table_cols($table_name) .'`;
        document.querySelector(`#scroller`).innerHTML += `'. Output::get_table_data($table_name) .'`;
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
		$query = "SELECT COLUMN_COMMENT FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME='".$table_name."' AND COLUMN_NAME='".$col."';";
		$query = Input::exec_tr($query);
		$is_inactive = is_in_array("inactive", "COLUMN_COMMENT", $query);
		if ($is_inactive)
		{
			echo '<script>
				document.querySelector("#add_form").innerHTML += `<input type="hidden" name="'.$col.'" value="1">`;
			</script>';
			continue;
		}
		else if (is_in_array($col, 'COLUMN_NAME', $index_cols))
		{
			echo '<script>
				document.querySelector("#add_form").innerHTML += `<select class="add_input" id="'.$col.'" name="'.$col.'"></select>`;
				document.querySelector("#'.$col.'").innerHTML = `<option class="add_options" disabled>'.$col.'</option>`;
			</script>';

			$ref_tab = Input::exec_tr("SELECT REFERENCED_COLUMN_NAME, REFERENCED_TABLE_NAME FROM information_schema.KEY_COLUMN_USAGE WHERE TABLE_NAME = '".$table_name."' AND COLUMN_NAME='".$col."';");
			$ref_col = $ref_tab[0]["REFERENCED_COLUMN_NAME"];
			$ref_tab = $ref_tab[0]["REFERENCED_TABLE_NAME"];

			$second_column = Input::exec_tr("SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME='" . $ref_tab . "';");
			$second_column = find_next($ref_col, $second_column);


			$fk_table_buff = Input::exec_tr("SELECT " . $ref_col . "," . $second_column . " FROM " . $ref_tab . ";");

			/*			визуальное представление данных, принимаемых посредством input::exec_tr()
			foreach ($fk_table as $v => $c)
			{
				print_r($fk_table[$v][$id_name] . " : " . $c[$second_column]);
				echo "<br>";
			}					поиск array_search("кг.", $fk_table)
			*/
			foreach ($fk_table_buff as $row)
			{
				$fk_table[$row[$id_name]] = $row[$second_column];
				echo '<script>
					document.querySelector("#'.$col.'").innerHTML += `<option class="add_options">'.$row[$second_column].'</option>`;
				</script>';
			}
		}
		else
		{
			$type = convert_sql_datatype($col);
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



function is_inputs_valid()
{
	global $table_name;
	global $id_name;
	global $pk_is_ai;

	$id_name = Input::exec_tr("SELECT COLUMN_NAME,EXTRA FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME='". $table_name ."' AND COLUMN_KEY='PRI';");
	if (is_in_array("auto_increment", 'EXTRA', $id_name)) $pk_is_ai = true;
	$id_name = $id_name[0]['COLUMN_NAME'];
	
	foreach (Output::get_cols($table_name) as $col)
    {
		if ($pk_is_ai && $col == $id_name) continue;
		$s = trim($_POST[$col]);
        if (empty($s) || $s == $col) return true;
    }
	return false;
}
if (isset($_POST["добавить"]))
{
	$table_name = $_POST["a_table_name"];
	if (is_inputs_valid())
	{
		update_table(array('table' => $table_name, 'notice' => $NODATAERR));
		return;
	}
	else
	{
		$query = "INSERT INTO " . $table_name . "(";
		
		$columns = "";
		$values = "";
		$index_cols = Input::exec_tr("SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = '". $table_name ."' AND COLUMN_KEY='MUL';");
		foreach (Output::get_cols($table_name) as $col)
		{
			if ($pk_is_ai && $col == $id_name) continue;

			$value = $_POST[$col];
			if (is_in_array($col, 'COLUMN_NAME', $index_cols))
			{
				$ref_tab = Input::exec_tr("SELECT REFERENCED_COLUMN_NAME, REFERENCED_TABLE_NAME FROM information_schema.KEY_COLUMN_USAGE WHERE TABLE_NAME = '".$table_name."' AND COLUMN_NAME='".$col."';");
				$ref_col = $ref_tab[0]["REFERENCED_COLUMN_NAME"];
				$ref_tab = $ref_tab[0]["REFERENCED_TABLE_NAME"];
				$second_column = Input::exec_tr("SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME='" . $ref_tab . "';");
				$second_column = find_next($ref_col, $second_column);
				$value = Input::exec_tr("SELECT ".$ref_col." FROM ".$ref_tab." WHERE ".$second_column."='".$_POST[$col]."';");
				$value = $value[0][$ref_col];
			}

			$columns .= $col . ", ";
			$values .= (is_varchar($col)) ? "'" . $value . "', " : $value . ", ";
		}
		$columns = rtrim($columns, ", ");
		$values = rtrim($values, ", ");
		
		$query .= $columns . ") VALUES(" . $values . ");";
		try
		{
			Input::execonly_tr($query);
		}
		catch(Exception $e)
		{
			update_table(array( 'table' => $table_name,'notice' => "Ошибка: недостаточно прав."));
		}
	}
	update_table(array( 'table' => $table_name));
}

if (isset($_POST["rem_confirm"]))
{
	//dis("pk is ai: ".$pk_is_ai);
	$table_name = $_POST["a_table_name"];
	$selected_col = $_POST["selected_class"];
	$selected_value = $_POST["selected_value"];
	if (empty($table_name) || empty($selected_col) || empty($selected_value))
	{
		update_table(array( 'table' => $table_name, 'notice' => "Ошибка: значение не выбрано."));
		return;
	}
	else
	{
		if (is_varchar($selected_col)) $selected_value = "'" . $selected_value . "'";
		//			CHECK FOR >1 MATCHES
		$query = "SELECT COUNT(*) FROM " . $table_name . " WHERE " . $selected_col . " = " . $selected_value . ";";
		$matches = Input::exec_tr($query);
		$matches = $matches[0]['COUNT(*)'];
		if ($matches > 1)
		{
			$id_name = Input::exec_tr("SELECT EXTRA FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME='". $table_name ."' AND COLUMN_KEY='PRI';");
			if (is_in_array("auto_increment", 'EXTRA', $id_name))
			{
				update_table(array( 'table' => $table_name, 'notice' => "Ошибка: найдено несколько совпадений. Выберите поле с уникальным значением."));
				return;
			}
		}
		$query = "DELETE FROM " . $table_name . " WHERE " . $selected_col . " = " . $selected_value . " LIMIT 1;";
		try
		{
			Input::execonly_tr($query);
		}
		catch(Exception $e)
		{
			//print_r($query);
			update_table(array( 'table' => $table_name,'notice' => "Ошибка: на этот элемент есть ссылка."));
		}
	}
	update_table(array( 'table' => $table_name));
}

if (isset($_POST["edit_button"]))
{
	$table_name = $_POST['a_table_name'];
	$id_name = $_POST['edit_id_name'];
	$id_value = $_POST['edit_id'];
	if (is_varchar($id_name)) $id_value = "'" .$id_value. "'";
	$column = $_POST['edit_column'];
	$old_value = $_POST['edited_value'];
	$new_value = $_POST['new_value'];
	if (is_varchar($column))
	{
		if (!empty($old_value)) $old_value = "'".$old_value."'";
		$new_value = "'".$new_value."'";
	}

	$query = "UPDATE ".$table_name." SET ".$column."=". $new_value ." WHERE " .$id_name."=". $id_value;
	if (!empty($old_value)) $query .= " AND ".$column."=". $old_value;
	try
	{
		//dis($query);
		Input::execonly_tr($query);
		update_table(array( 'table' => $table_name));
	}
	catch(Exception $e)
	{
		print_r($_POST);
		update_table(array( 'table' => $table_name,'notice' => "Ошибка: идентификатор не определён."));
	}
}

function query_table($table)
{
	$cols = array_keys($table[0]);

	$cols_schema = '<div class="row">';
	foreach ($cols as $cell)
	{
		$cols_schema .= '<div class="cell ' . $cell . '">' . $cell . '</div>';
	}
	$cols_schema .= '</div>';

	$table_schema = '';
	foreach ($table as $col => $row)
	{
		$table_schema .= '<div class="row">';
		foreach ($row as $col => $cell)
		{
			$table_schema .= '<div class="cell '. $col .'">' . $cell . '</div>';
		}
		$table_schema .= '</div>';
	}
	echo '<script>
		document.querySelector("#scroller").innerHTML = `'. $cols_schema .'`;
		document.querySelector("#scroller").innerHTML += `'. $table_schema .'`;
    </script>';
}

function set_name($value)
{
	global $tables;
	echo '<script>
		document.querySelector(`#table_name`).innerHTML = `<option value="" name="first_element" id="first_element"></option>`;
	</script>';
    foreach ($tables as $name) {
        echo '<script>
            document.querySelector(`#table_name`).innerHTML += `<option value="'. $name['TABLE_NAME'] .'">'. to_upper($name['TABLE_NAME']) .'</option>`;
        </script>';
    }
	echo '<script>
		document.querySelector(`#first_element`).innerHTML = `'.$value.'`;
	</script>';
}

if (isset($_POST['ft_confirm_button']) && 
	!empty($_POST['from']) && !empty($_POST['to']) && 
	$_POST['to'] > $_POST['from']
)
{
	$table = Input::exec_tr("SELECT №_накладной, дата, сумма, наименование_поставщика FROM приход WHERE дата BETWEEN '".$_POST['from']."' AND '".$_POST['to']."' ORDER BY сумма DESC;");
	if (count($table) < 1)
	{
		update_table(array( 'table' => $table_name,'notice' => "Внимание: нет совпадений по выбранному периоду."));
		return;
	}
	query_table($table);
	set_name($_POST['from'].'=>'.$_POST['to']);
	return;
}
if (isset($_POST['rashod_button']) && 
	!empty($_POST['r_from']) && !empty($_POST['r_to']) && 
	$_POST['r_to'] > $_POST['r_from']
)
{
	$table = Input::exec_tr("SELECT №_заявки, тип_расхода, дата, сумма, название_склада FROM расход WHERE дата BETWEEN '".$_POST['r_from']."' AND '".$_POST['r_to']."' ORDER BY сумма DESC;");
	if (count($table) < 1)
	{
		update_table(array( 'table' => $table_name,'notice' => "Внимание: нет совпадений по выбранному периоду."));
		return;
	}
	query_table($table);
	set_name($_POST['r_from'].'=>'.$_POST['r_to']);
	return;
}
if (isset($_POST['fin_confirm_button']) && !empty($_POST['month']))
{
	$month = substr($_POST['month'], 0, 7);
	$table = Input::exec_tr("SELECT п.сумма AS 'сумма прихода', р.сумма AS 'сумма расхода'
		FROM (SELECT SUM(сумма) AS сумма FROM приход WHERE дата LIKE '".$month."%') AS п,
			 (SELECT SUM(сумма) AS сумма FROM расход WHERE дата LIKE '".$month."%') AS р;
	");
	if (count($table) < 1)
	{
		update_table(array( 'table' => $table_name,'notice' => "Внимание: нет совпадений по выбранному периоду."));
		return;
	}
	query_table($table);
	set_name($month);
	return;
}
if(isset($_POST['top10_button']))
{
	$table = Input::exec_tr("SELECT t.артикул, t.наименование,
		SUM(d.количество) AS 'количество проданного',
		SUM(d.стоимость) AS 'сумма проданного'
		FROM Товары AS t
		INNER JOIN Состав_расхода AS d ON t.артикул = d.артикул_товара
		GROUP BY t.артикул, t.наименование
		ORDER BY SUM(d.стоимость) DESC
		LIMIT 10;
	");
	if (count($table) < 1)
	{
		update_table(array( 'table' => $table_name,'notice' => "Внимание: список продаж пуст."));
		return;
	}
	query_table($table);
	set_name("ТОП 10 ПРОДАЖ");
	return;
}
if (isset($_POST['categ_rep_button']))
{
	$table = Input::exec_tr("SELECT категория, COUNT(*) AS количество_товаров
		FROM товары
		GROUP BY категория;
	");
	if (count($table) < 1)
	{
		update_table(array( 'table' => $table_name,'notice' => "Внимание: товары не найдены."));
		return;
	}
	query_table($table);
	set_name("ОТЧЁТ ПО КАТЕГОРИЯМ");
	return;
}
update_table();
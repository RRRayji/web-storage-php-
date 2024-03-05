<?php
$ID_NAME = "ид";
$table_name = "ПОСТАВЩИК";

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
    // Получение списка таблиц
	echo '<script>
            document.querySelector(`#table_name`).innerHTML = `<option value="" name="first_element" id="first_element"></option>`;
        </script>';
    $tables = Input::exec_tr("SELECT TABLE_NAME FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA='CatalogDB';");
    foreach ($tables as $name) {
        echo '<script>
            document.querySelector(`#table_name`).innerHTML += `<option>'. to_upper($name['TABLE_NAME']) .'</option>`;
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

    // Установка имени таблицы в скрытом поле формы
    echo '<script>
        document.querySelector("#a_table_name").value = `'. $table_name .'`;
    </script>';
    return $table_name;
}

update_table();

// Проверка, является ли поле 'ид' с автоинкрементом
$is_auto_increment = false;
$id_extras = Input::exec_tr("SELECT EXTRA FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = '". $table_name ."' AND COLUMN_NAME = '". $ID_NAME ."';");
foreach ($id_extras as $ex)
{
    if ($ex['EXTRA'] == "auto_increment")
    {
        $is_auto_increment = true;
        break;
    }
}

// Заполнение формы
echo '<script>
    document.querySelector("#add_form").innerHTML = `<input type="hidden" id="a_table_name" name="a_table_name" value="'. $table_name .'">`;
</script>';
foreach (Output::get_cols($table_name) as $cell) {
    if ($is_auto_increment && $cell == $ID_NAME) {
        continue;
    }
    echo '<script>
        document.querySelector("#add_form").innerHTML += `<input type="text" class="add_input" id="'. $cell .'" name="'. $cell .'" placeholder="'. $cell .'" required>`;
    </script>';
}

// Добавление кнопки "добавить" к форме
echo '<script>
    document.querySelector("#add_form").innerHTML += `<input type="submit" class="add_input" id="добавить" name="добавить" value="ДОБАВИТЬ">`;
</script>';

// Обработка отправки формы
if (isset($_POST["добавить"]))
{
    $table_name = $_POST["a_table_name"];
    $query = "INSERT INTO " . $table_name . "(";

    // Формирование списка столбцов
    $columns = "";
    foreach (Output::get_cols($table_name) as $cell)
    {
        if ($is_auto_increment && $cell == $ID_NAME)
        {
            continue;
        }
        $columns .= $cell . ", ";
    }
    $columns = rtrim($columns, ", ");

    // Формирование списка значений
    $values = "";
    foreach (Output::get_cols($table_name) as $cell)
    {
        if ($is_auto_increment && $cell == $ID_NAME)
        {
            continue;
        }
        $values .= "'" . $_POST[$cell] . "', "; // Оборачиваем значения в кавычки, если это строки
    }
    $values = rtrim($values, ", ");

    $query .= $columns . ") VALUES(" . $values . ");";

    Input::execonly_tr($query);
    update_table($table_name);
}
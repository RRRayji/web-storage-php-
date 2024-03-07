<?php
public static function get_table_data($table_name)
{
	$table_names = get_cols($table_name);
	$count = (int)Input::exec_tr("SELECT COUNT(COLUMN_NAME) FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = '$table_name'");
	$table_schema = '';
	foreach (Input::exec_tr("SELECT * FROM $table_name") as $col => $row)
	{
		$table_schema .= '<div class="row">';
		foreach ($row as $cell)
		{
			print_r($row);
			$table_schema .= '<div class="cell">' . $cell . '</div>';
		}
		$table_schema .= '</div>';
	}
	return $table_schema;
}

get_table_data("ПОСТАВЩИК");
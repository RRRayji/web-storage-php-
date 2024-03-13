<?php

class SQLData {
    protected static $conn = null;
    protected static $servername = "localhost";
    protected static $dbname = "test";
    protected static $user = "root";
    protected static $password = "";

	public static function Init()
	{
		try
		{
			self::$conn = new PDO("mysql:host=" . self::$servername . ";dbname=" . self::$dbname, self::$user, self::$password);
			self::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		}
		catch (PDOException $e)		//	Отлавливаем подключение к базе данных и, если её не существует
		{									//	на устройстве, производим восстановление по backup-файлу.
			echo "Connection error:\n" . $e->getMessage();
			self::$conn = new PDO("mysql:host=localhost;dbname=mysql", "root", "");
			echo '<script>alert("Error: someting went wrong!");</script>';
			self::$conn->exec("CREATE DATABASE " . self::$dbname);
			echo '<script>alert("The database creation...");</script>';
			
			self::$conn = new PDO("mysql:host=" . self::$servername . ";dbname=" . self::$dbname, self::$user, self::$password);
			echo '<script>alert("Successfully connected!");</script>';
			self::$conn->exec(Input::load_data());
			echo '<script>alert("The database has been restored.");</script>';
		}
	}
}


class Output extends SQLData
{
	public static function get_cols($table_name)	//	возвращает названия столбцов введённой таблицы
	{
		$query = "SELECT COLUMN_NAME
		FROM INFORMATION_SCHEMA.COLUMNS
		WHERE TABLE_SCHEMA = '" . parent::$dbname . "'
		AND TABLE_NAME = '$table_name'";
	
		$cols_buff = Input::exec_tr($query);
		$cols = array();
	
		foreach($cols_buff as $col)
		{
			$cols[] = $col['COLUMN_NAME'];
		}
		
		return $cols;
	}

	public static function get_data($table_name)
	{
		$values = Input::exec_tr("SELECT * FROM $table_name");
		$rows = array();
	
		foreach ($values as $row_index => $value)
		{
			foreach (Output::get_cols($table_name) as $col_index => $col)
			{
				$rows[$row_index][$col_index] = $value[$col];
			}
		}
		
		return $rows;
	}

	public static function get_table_cols($table_name)
	{
		$cols_schema .= '<div class="row">';
		foreach (Output::get_cols($table_name) as $cell)
		{
			$cols_schema .= '<div class="cell ' . $cell . '">' . $cell . '</div>';
		}
		$cols_schema .= '</div>';
		return $cols_schema;
	}

	public static function get_table_data($table_name)
	{
		$count = (int)Input::exec_tr("SELECT COUNT(COLUMN_NAME) FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = '$table_name'");
		$table_schema = '';
		foreach (Input::exec_tr("SELECT * FROM $table_name") as $col => $row)
		{
			$table_schema .= '<div class="row">';
			foreach ($row as $col => $cell)
			{
				$table_schema .= '<div class="cell '. $col .'">' . $cell . '</div>';
			}
			$table_schema .= '</div>';
		}
		return $table_schema;
	}

	public static function print_table($table_name)		//	отладочная функция.
	{
		echo get_table_cols($table_name);
		echo get_table_data($table_name);
	}
}
//			" ebal ya ety paboty " © I_KAUFMANN 16:18 04.03.2024
class Input extends SQLData
{
	public static function load_data()	//	backup-файл
	{
		$file = fopen("source/catalogdb.sql", "r") or die("Unable to load file!");
	
		$data = "";
		while (!feof($file))
		{
			$data .= fgets($file);
		}
		
		fclose($file);
		return $data;
	}

	public static function exec_tr($query)		//	trusted: будет проверять наличие подключения к базе данных.
	{
		if (isset(parent::$conn) && parent::$conn instanceof PDO)
		{
			$stm = parent::$conn->prepare($query);
			$stm->execute();
			return $stm->fetchAll(PDO::FETCH_ASSOC);
		}
		print_r("conn value: " . parent::$conn);
		die("Connection lost at exec_tr().");
	}

	public static function execonly_tr($query)		//	trusted: будет проверять наличие подключения к базе данных.
	{
		if (isset(parent::$conn) && parent::$conn instanceof PDO)
		{
			$stm = parent::$conn->prepare($query);
			return $stm->execute();
		}
		print_r("conn value: " . parent::$conn);
		die("Connection lost at exec_tr().");
	}
}

SQLData::Init();

?>
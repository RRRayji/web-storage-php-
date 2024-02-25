<?php
function addTwoEach($a, $b, ...$args)
{
    echo $a . '<br>';
    echo $b . '<br>';
    
    $sum = array_sum($args);
    $result = $sum + 2 * count($args);

    return $result;
}

//			Example usage
$result = addTwoEach(1, 2, 3, 4, 5);
echo $result;	// Outputs	1
				//			2
				//			18

//						foreach example
foreach (Output::get_cols($table_name) as $col_index => $col)
{
	$rows[$row_index][$col_index] = $value[$col];
}

?>

<?php		//	i can connect another .php file and use the variable from it.
include 'source/features.php';		//	from the main file include this file.
?>
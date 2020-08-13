<?php

ini_set('max_execution_time', 0);
ini_set('memory_limit ', -1);

include "./include/simple_html_dom.php";

$excel_file=file_get_contents("raw_table.txt");
$excel_file = preg_replace('/\s+/', '', $excel_file);

//file_put_contents('data.txt', $excel_file);

$html = str_get_html($excel_file);

//libxml_use_internal_errors(true);
// $doc = new DOMDocument();
// $doc->loadHTML($html);
// echo $doc->saveHTML();

header('Content-type: application/ms-excel');
header('Content-Disposition: attachment; filename=samplex.csv');

//$fp = fopen("php://output", "w");
$file_name = date('Ymdhis');
$fp = fopen("{$file_name}.csv", 'w');

foreach($html->find('tr') as $element)
{
    $td = array();
    foreach( $element->find('th') as $row)  
    {
        $td [] = $row->plaintext;
    }
	
	if ($td){
		fputcsv($fp, $td);
	}

    $td = array();
    foreach( $element->find('td') as $row)  
    {
        $td [] = $row->plaintext;
    }
    fputcsv($fp, $td);
}

fclose($fp);





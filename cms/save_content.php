<?php include "read_template.php"; 
//Loads the xml content



$selected_page = $_POST['tempFile'];
$selected_content = $_POST['contentSelect'];
$content = $_POST['content'];

if(!(strlen($selected_page))>0){//If no page selected return to editor
    header("Location: editor.php") ;
    exit;    
}else if(!(strlen($selected_content))>0){//If not content selected return to editor
    header("Location: editor.php?page=".urlencode($selected_page)) ;
    exit;    
}


$content_array = load_content($selected_page);


//edited content add content array
$content_array[$selected_content] = $content;
 

 
$xml_output = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
$xml_output .= "<about>\n";
$xml_output .= "<contents>\n";
while (list($key, $value) = each($content_array)) {
    $xml_output .= "<item>\n";
    $xml_output .= "<title>". $key  ."</title>\n";
    $xml_output .= "<content><![CDATA[". $value  ."]]></content>\n";
     $xml_output .= "</item>\n";    
 }
 $xml_output .= "</contents>\n";
$xml_output .= "</about>\n";
 
   
//echo htmlspecialchars($xml_output);

$root="vhosts/optimayazilim.com/http/projects/sarikilic/";
$xml_file_location="/".$root."cms/xml/".$selected_page."_temp.xml";

$fp = fopen($xml_file_location, 'w'); //Open the file with write privilege
fwrite($fp, $xml_output);//Write the file
fclose($fp);//Close the file
 
header("Location: editor.php?page=".urlencode($selected_page)."&selected_content=".urlencode($selected_content)."&saved=1") ;
exit;

?>




<?php include "../cms/read_template.php"; 
//Loads the xml content



$selected_page = $_POST['selected_page'];
$selected_content = $_POST['selected_content'];
$content_array = load_content($selected_page);


$content = get_content($selected_page,$selected_content);  

$output = "success";
$arr = array('status' => $output, 'content' => $content);
echo json_encode($arr);
?>
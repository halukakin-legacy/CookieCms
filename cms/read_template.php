<?php


$content_array=array();//Holds the data from the loaded xml.

/**
 * 
 * Loads the xml content using the input title
 * 
 */
function load_content($xml_name){
    $root="vhosts/optimayazilim.com/http/projects/sarikilic/";
    $xml_file_location="/".$root."cms/xml/".$xml_name."_temp.xml";
    
    $xml = simplexml_load_file($xml_file_location);

    //$content_array=xml2array($xml);
    
    
    
    
    foreach($xml->contents->children() as $child){
        //echo $child->attributes();
        $content_array[(string)$child->title]=(string)$child->content;//$child->text; 
    }
    return $content_array;
    //print_r($content_array);//Debug
                 
    //echo $xml->contents->getName() . "<br />";
    /*
    $topContent = $xml->contents->topContent;
    $leftContent = $xml->contents->leftContent;
    $rightContent = $xml->contents->rightContent;    
    */
}

/**
 * 
 * Echoes the content for the specific content sections
 * 
 */
function show_content($xml_name,$content_title){
    global $content_array;
    echo stripslashes($content_array[$content_title]);
}


/**
 * 
 * Returns the content for the specific content sections
 * 
 */
function get_content($xml_name,$content_title){
    global $content_array;
    return stripslashes($content_array[$content_title]);
}
 

?>
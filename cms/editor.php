<?php
//TODO:Left navigation should display xml titles, not xml file names

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>CMS Editor</title>

<script type="text/javascript" src="js/jquery-1.4.4.min.js"></script>

<script type="text/javascript" src="ckeditor/ckeditor.js"></script>
<link href="ckeditor.css" rel="stylesheet" type="text/css" />


<script type="text/javascript">


$(document).ready(function() {
    CKEDITOR.replace( 'content',
	{
	   scayt_autoStartup : false,

		toolbar :
		[
        	{ name: 'document', items : [ 'Source' ] },
        	{ name: 'clipboard', items : [ 'Cut','Copy','Paste','-','Undo','Redo' ] },
        	{ name: 'editing', items : [ 'Find','Replace','-','SelectAll' ] },
        	'/',
        	{ name: 'basicstyles', items : [ 'Bold','Italic','Underline','Strike','Subscript','Superscript','-','RemoveFormat' ] },
        	{ name: 'paragraph', items : [ 'NumberedList','BulletedList','-','Outdent','Indent','-','JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock' ] },
        	{ name: 'links', items : [ 'Link','Unlink' ] },
        	{ name: 'insert', items : [ 'Image','Table','SpecialChar' ] },
        	'/',
        	{ name: 'styles', items : [ 'Styles','Format','Font','FontSize' ] },
        	{ name: 'colors', items : [ 'TextColor','BGColor' ] },
        	{ name: 'tools', items : [ 'Maximize', 'ShowBlocks','-','About' ] }
		]
	});
 
});

</script>

<?php include "read_template.php"; 
$tempFile = $_GET['page'];
$selected_content=$_GET['selected_content'];


if(strlen($tempFile)>1){
    $content_array = load_content($tempFile); //Get the content    
}


//if there is no selected_content in the get, let's get the initial one
if(!(strlen($selected_content)>0)){
    foreach( $content_array as $key => $value){
    	$selected_content=$key;
        break;
    }    
}
  


?>

</head>
<body>


<script type="text/javascript">

function contentSelect_dropdown(){
    
    selected_content = $("#contentSelect").val();
    contentSelect_change(selected_content);
    
}

function contentSelect_change(selected_content){
    
    //selected_content = $("#contentSelect").val();
    selected_page = '<?php echo $tempFile?>';
    
    $.ajax({
		type: "POST",
		url: "content_select_for_editor.php",
		data: 	"selected_page=" + selected_page+
                "&selected_content=" + selected_content,
                
               
		success: function(data){
            data=$.trim(data);    
            var obj = jQuery.parseJSON(data);   
             if(obj.status=="success"){
                
               //$("#content").text(obj.content);
               CKEDITOR.instances.content.setData(obj.content);
                
            }     
		},
        error: function(data){
            
           
                           
        }
	});
    
}

<?php 

if(strlen($selected_content)>0){ ?>
    $(document).ready(function() {
        contentSelect_change("<?php echo $selected_content;?>");
        });
<?php } ?>

</script>




<div style="clear:both;"></div>
<div style="float:  left;width: 150px;height: 250px;">  


<?php
//take Xml pages from Xml folder
$dir = "xml";
$dh  = opendir($dir);
while (false !== ($filename = readdir($dh))) {
    
    //echo $filename.' :'. is_file('xml/'.$filename).'<br>'; //
    if(is_file('xml/'.$filename)){
         $xml_filename = explode('_',$filename);
         $xml_name = $xml_filename['0'];
         echo "<a href=\"editor.php?page=".$xml_name."\">".$xml_name."</a><br>\r\n";
    }        
}
?>
 </div>

<div style="  float: left;width: 815px;" >

<?php if($_GET['saved']==1) { ?>
<div ><span style="color: green;">İçerik Başarıyla Güncellendi</span></div>
<?php }?>

<?php if(strlen($tempFile)>1){//Only show when there is a page loaded
 ?>
<form id="form1" action="save_content.php" method="post">
    <div ><span>İçerik Seçiniz</span>
         <input type="hidden" id="tempFile" name="tempFile"  value="<?php echo $tempFile?>"/>
         <select id="contentSelect" name="contentSelect" onchange="contentSelect_dropdown();">
            
            <?php
            if(!(strlen($selected_content)>0)){//If we do not see any selected content default should be Choose
                $s="selected=\"selected\"";
            }
            ?>
            
         
            <option value="" <?php echo $s;?> >---Seçiniz--</option>
            <?php 
                   foreach( $content_array as $key => $value){
                        if($key==$selected_content){ ?>
                            <option value="<?php echo $key;?>" selected="selected"><?php echo $key;?></option>
                        <?php }else{ ?>
                            <option value="<?php echo $key;?>"><?php echo $key;?></option>
                        <?php }     
                   } ?>            
            
         </select>
    </div>
    <div ><span>İçerik </span>

         <textarea class="ckcontent" id="content" name="content" rows="10" cols="40"></textarea>

         
            
                      
            
         </textarea>

    </div>
    <div >
        <input type="submit" name="save"  value="Kaydet"/>
    </div>

</form>
<?php } ?>
</div>

</body>
</html>
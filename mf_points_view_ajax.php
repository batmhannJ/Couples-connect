<?php
	ini_set('display_errors', '1');
	ini_set('display_startup_errors', '1');
	error_reporting(E_ALL);	
	$xretobj='';

	if(isset($_POST['action']) && trim($_POST['action']) == "zoom")
	{
		$xretobj="";
		//$xretobj.="<div style='position:fixed;top:10px; width:500px;  height:300px;  border:3px solid #73AD21;'>";
		//$xretobj.="hello world:".$_POST['recid'];
		//$xretobj.="</div>";
		
		$xretobj.= "<img name='img_modal' id='img_modal' alt='no image' src='".$_POST['xsrc']."' ";	
		
		
		if ($_POST['sel_zoom']!='original')
		{
			$_POST['sel_zoom'] = $_POST['sel_zoom'].="%";
			$xretobj.= "style='width:".$_POST['sel_zoom'].";height: auto;'";
		}
		
		$xretobj.= ">";
	}
	// elseif(isset($_POST['action']) && trim($_POST['action']) == "view_meridian")
	// {
	// 	$xretobj=array();
	// 	$xqry="SELECT * FROM meridiansfile where meridian='".$_POST['meridian']."'";
	// 	$xstmt=$link_id->prepare($xqry);
	// 	$xstmt->execute();
	// 	$xrs1 = $xstmt->fetch();
		
	// 	$xretobj['mer_image1']=$xrs1['mer_image1'];	
			
	// 		$order='ASC';			
	// 		switch ($xrs1['meridian']) {
	// 			case "LI":
	// 			case "SJ":
	// 			case "SI":
	// 			case "LV":
	// 			case "KD":
	// 			case "SP":
	// 				$order='DESC';
	// 				break;
	// 		}	
		
		
		
	// 		$xqry3="SELECT * FROM pointsfile where meridian='".$xrs1['meridian']."' and (point_category!='' or point_category2!='' ) order by recid ".$order;
	// 		$xstmt3=$link_id->prepare($xqry3);
	// 		$xstmt3->execute();
			
	// 		$innerhtml="<table border=0 style='border:1px solid;' >";
	// 		while($xrs3 = $xstmt3->fetch())
	// 		{
	// 			$innerhtml=$innerhtml."<tr>";
				
				
	// 			//$cat=$xrs3['point_category']."\r\n".$xrs3['point_category2'];
	// 			$cat=$xrs3['point_category'];
				
	// 			$style="width:60px";
	// 			switch (strtoupper(substr($cat,0,2))) {
	// 			case "JI":
	// 			case "YI":
	// 			case "SH":
	// 			case "JI":
	// 			case "HE":
	// 				$style.=";color:blue";
	// 				break;
	// 			case "XI":
	// 				$style.=";color:purple";
	// 				break;
	// 			case "LU":
	// 				//$style.=";color:#16A085";
	// 				$style.=";color:green";
	// 				break;
	// 			}
	// 			$innerhtml=$innerhtml."<td style='".$style."'>".$xrs3['point_code']."</td>";
				
	// 			$style="font-size:small;width:200px";
	// 			$innerhtml=$innerhtml."<td style='".$style."' > ".$cat." </td> ";
	// 			$innerhtml=$innerhtml."</tr>";
	// 		}
	// 		$innerhtml.="</table>";
		
	// 		$xretobj['innerhtml'] = $innerhtml;
			
		
		
	// }

	echo json_encode($xretobj);
?>
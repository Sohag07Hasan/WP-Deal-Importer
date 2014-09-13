<?php 

var_dump($_POST);

	if($_POST['category_import'] == 'Y'){ //conditionally check if the form is submitted
		if(!empty($_FILES['category_file']['tmp_name'])){
			$xls = $this->get_excel_parser($_FILES['category_file']['tmp_name']);
			
			
			for($row=1;$row<=$xls->rowcount($sheet);$row++){
					//self::$current_row = array();
					
					for($col=1;$col<=$xls->colcount($sheet);$col++) {
						$rowspan = $xls->rowspan($row,$col,$sheet);
						$colspan = $xls->colspan($row,$col,$sheet);
						for($i=0;$i<$rowspan;$i++) {
							for($j=0;$j<$colspan;$j++) {
								if ($i>0 || $j>0) {
									$xls->sheets[$sheet]['cellsInfo'][$row+$i][$col+$j]['dontprint']=1;
								}
							}
						}
						
						if(!$xls->sheets[$sheet]['cellsInfo'][$row][$col]['dontprint']) {
							$val = $xls->val($row,$col,$sheet);
							
							var_dump($val);
							
							/*
							if($row == 1){
								self::$headers[] = explode("|", $val);
							//	self::$headers[] = $val;
							}
							if($row == 2){
								self::$descriptions[] = $val;
							}
							
							if($row >= 3){
								self::$current_row[] = $val;
							}
							 * 
							 * *
							 */
						}
					}
				
		}
	}
}
?>

<div class="wrap">
	<h2> Categories importing </h2>
		
	<p>Please use the prescribed <a href="<?php echo $this->get_demo_xls_file(); ?>"> format </a> </p>
	
	
	<form action="" method="post" enctype="multipart/form-data" >
		<input type="hidden" name="category_import" value="Y" />
		
		<table class="form-table">
			<tr>
				<td> <input type="file" name="category_file" /> <input type="submit" value="import" class="button-primary" /></td>
			</tr>
		</table>
	
	</form>
</div>
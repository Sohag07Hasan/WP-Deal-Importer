<?php 

var_dump($_POST);

if($_POST['category_import'] == 'Y'){ //conditionally check if the form is submitted
	if(!empty($_FILES['category_file']['tmp_name'])){
		$csv = $this->get_csv_parser();
		$csv->heading = false;
		$csv->delimiter = ",";
		$csv->parse($_FILES['category_file']['tmp_name']);
		//print_r($csv->data);
		
		var_dump(count($csv->data));
		
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
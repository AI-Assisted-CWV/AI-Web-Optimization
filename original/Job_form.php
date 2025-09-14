<?php 
	
	require 'database.php';

	if ( !empty($_POST)) {
		
		// keep track post values	
		$name = $_POST['name'];
		$bdate = $_POST['bdate'];
		$education = $_POST['education'];
		$speci = $_POST['speci'];
		$phone = $_POST['phone'];
		$email = $_POST['email'];
		$branch = $_POST['branch'];
		$path = 'cv\\'.$_POST['name'];		
		$ip= $_SERVER['REMOTE_ADDR'];
		
		
		// validate input
		$valid = true;
	
		// insert data
		if ($valid) {
			
			$filename=$_FILES["cv"]["name"];
			$extension=end(explode(".", $filename));
			
			$pdo = Database::connect();
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = "INSERT INTO cv (name,bdate,education,speci,phone,email,branch,path,ip) values(?, ?, ?, ?,?,?,?,?,?)";
			$q = $pdo->prepare($sql);
			$q->execute(array($name,$bdate,$education,$speci,$phone,$email,$branch,$extension,$ip));
			

			$newfilename=$pdo->lastInsertId() .".".$extension;
			//move_uploaded_file($_FILES["cv"]["tmp_name"], "CV/" .$newfilename);
			
			Database::disconnect();
			$saved=1;
		}
	}
?>


<!DOCTYPE html>
<html lang="ar">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
</script> 
  </head>

<body>
<div class="container-fluid" style="width:75%; text-align:justify; direction:rtl;">

	<?php require_once("header.php");?>
    
    				<div class="row" align="Center">
		    			<?php
						    if(isset($saved))
							{
							echo '<div class="alert alert-info">';
                            echo '<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>';
                            echo '<strong>تم حفظ البيانات بنجاح</strong>';
                            echo '</div>';
							}
							else
							{
								echo "<h2>طلب توظيف</h2>";
							}
						?>
		    		</div>
					
					<form class="form-horizontal" enctype="multipart/form-data" action="Job_form.php" method="post">
						
						<label>الاسم</label>
						<input style="text-align: right" class="form-control" name="name" type="text" required>
                        
                        <label>تاريخ الميلاد</label>
						<input style="text-align: right" class="form-control" name="bdate" type="date" required>

					    <label class="control-label">المؤهل العلمي</label>						
                        <select name="education" size="1" class="form-control">
							<option value="1" >دكتوراه</option>
							<option value="2">ماجستير</option>
							<option value="3" selected>بكالوريوس</option>
							<option value="4">دبلوم</option>
							<option value="5">ثانوية عامة</option>
                        </select>
                        
                        <label>التخصص</label>
						<input style="text-align: right" class="form-control" name="speci" type="text" required>
                        
					    <label class="control-label">رقم الهاتف</label>
					    <input style="text-align: right" class="form-control" name="phone" type="text" required>
                        
					    <label class="control-label">البريد الاكتروني</label>
					    <input style="text-align: right" class="form-control" name="email" type="email" required>                        
							
					    <label class="control-label">الفرع الذي ترغب العمل به</label>						
                        <select name="branch" size="1" class="form-control">
							<option value="1" selected>جنين</option>
							<option value="2">رام الله</option>
							<option value="3">نابلس</option>
							<option value="4">الخليل</option>
							<option value="5">طوباس</option>
                            <option value="6">يطا</option>
                        </select>	
                        				
					    <label class="control-label">ارفق السيرة الذاتية</label>
					    <input style="text-align: right" class="form-control" name="cv" type="file" required>						
                        
						<hr>
						<div align="Center">
						<button type="submit" class="btn btn-success">حفظ</button>
						<a class="btn btn-default" href="index.php">للخلف</a>
						</div>
						
					</form>
<hr>
				<?php require_once('footer.php'); ?>
				
    </div> <!-- /container -->
  </body>
</html>
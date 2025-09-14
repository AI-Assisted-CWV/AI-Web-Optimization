<?php
// Start output buffering to prevent "headers already sent" errors
ob_start();
// Include all necessary PHP files at the top
require_once("header2.php");
// End output buffering and send all content to the browser
ob_end_flush();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
</head>

<body>
<div class="container-fluid" style="width:100%; text-align:right; direction:rtl">

    		<div class="row" align="Center">
    			<h1>جدول المواد</h1>
                <?php
				
					include '../database.php';
					$pdo = Database::connect();
					$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
					$sql = "SELECT count(*) as items FROM course";
					$q = $pdo->prepare($sql);
					$q->execute();
					$row=$q->fetch(PDO::FETCH_ASSOC);
					$rec_count =$row['items'];
					$rec_limit=8;
					$page_count=$rec_count/$rec_limit;
					
					if( isset($_GET{'page'} ) )
					{
						$page = $_GET{'page'}-1;
						$start = ($rec_limit * $page) ;
					 }else {
						$page=0;
						$start = 0;
					 }

					echo '<ul class="pagination pagination-sm">';
					for($index = 0; $index<=$page_count;$index=$index+1)
					{
					    $index2=$index+1;
						if($index2==($page+1))
						$active="active";
						else
						$active="";
					    echo "<li class='$active'><a href='c_index.php?page=$index2'>Page $index2</a></li>";

					}
					echo '</ul>';
				?>
                </div>
            <form action="ca_delete.php" method="post">
				<p>
					<a href="c_create.php" class="btn btn-success btn-sm">مادة جديدة</a>
                   <!-- <button id='deleteAll' class='btn btn-danger btn-sm ' onClick="return confirm('Are you sure you want to delete selected items')" type="submit" name="remove_levels" value="delete">حذف المحدد</button> -->
                    
				</p>
                <div class="table-responsive">
				<table class="table table-striped table-bordered">
		              <thead>
		                <tr>
		                  <th></th>
		                  <th>رقم المادة</th>
		                  <th>العنوان</th>
		                  <th>مدتها بالاسابيع</th>
                          <th>عدد الساعات</th>
                          <th>مستوى المدرس</th>
                          <th>مستوى الدارس</th>
                          <th>ملاحظات</th>
                          <th>الاجراء</th>
		                </tr>
		              </thead>
                      
		              <tbody>                   
		              <?php 

					  // $sql = 'SELECT * FROM teacher ORDER BY Teacher_ID DESC';
						
						if(isset($_POST['search']))
						{
							$search='%'.$_POST['search'].'%';
							$start=0;
							$rec_limit=1000000;
						}
							else{
						   $search="%%";
					     }
						 
						$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
						$sql = "SELECT * FROM course where Title like ? or Weeks like ? or Hours like ? or Teacher_Spec like ? or Level like ? LIMIT $start, $rec_limit";
						$q = $pdo->prepare($sql);
						$q->execute(array($search,$search,$search,$search ,$search));

						if(isset($_POST['search']))
						{
							if ($q->rowCount()==0)
							{
								echo '<div class="alert alert-danger">';
								echo '<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>';
  								echo '<strong>لا يوجد نتائج للبحث. لعرض الجدول كاملا اترك حقل البحث فارغ ثم اضغط على بحث </strong>';
								echo '</div>';
							}
							else 
							{
								echo '<div class="alert alert-success">';
								echo '<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>';
  								echo '<strong>تم ايجاد '.$q->rowCount().' سجل </strong>';
								echo '</div>';

							}
						}


	 				   while ($row=$q->fetch(PDO::FETCH_ASSOC)) {
						   		echo '<tr>';
							   	echo '<td><input type="checkbox" name="c_id[]" id="c_id[]" value="'.$row['Course_ID'].'"></td>';
							   	echo '<td>'. $row['Course_ID'] . '</td>';
							   	echo '<td>'. $row['Title'] . '</td>';
								echo '<td>'. $row['Weeks'] . '</td>';
								echo '<td>'. $row['Hours'] . '</td>';
								echo '<td>'. $row['Teacher_Spec'] . '</td>';
								echo '<td>'. $row['Level'] . '</td>';
								echo '<td>'. $row['Notes'] . '</td>';
							   	echo '<td>';
						//  	echo '<a class="btn btn-default disabled" href="t_read.php?id='.$row['Teacher_ID'].'">قراءة</a>';
							   	echo '&nbsp;';
							   	echo '<a class="btn btn-success btn-sm" href="c_update.php?id='.$row['Course_ID'].'">تعديل</a>';
							   	echo '&nbsp;';
							   	echo '<a class="btn btn-danger btn-sm disabled" href="c_delete.php?id='.$row['Course_ID'].'">حذف</a>';
							   	echo '</td>';
							   	echo '</tr>';
					   }
					   Database::disconnect();
					  ?>
                      </tbody>
                      </table>                    
                </div>
                 </form>
                 
                  <form action="" method="post">
                  <input name="search" type="text">
                  <input name="submit" type="submit" value="بحث" class="btn btn-success btn-sm">
                  </form> 
                <?php require_once('../footer.php'); ?> 
                </div>
  </body>
</html>
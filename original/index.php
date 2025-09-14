<!DOCTYPE html>
<html lang="ar">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
  </head>

<body>
<div class="container-fluid" style="width:75%; text-align:justify; direction:rtl;">

<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = 'https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.11';
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>

<?php

    require_once("header.php");
    require_once('database.php');
	$pdo=Database::connect();
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	$sql="select * from t_course";
	$result=$pdo->prepare($sql);
	$result->execute();
?> 

<div class="row">
  <div class="col-md-6 col-sm-push-3">
     					<div class="fb-page" 
                          data-tabs="timeline"
                          data-href="https://www.facebook.com/WorldTechnicalElite"
                          data-width="800" 
                          data-show-facepile="false"
                          data-adapt-container-width="true"
                          small_header="true";
                          data-hide-cover="true">
             	       </div>  
                       <hr>          
  </div>
  
  <div class="col-md-3 col-sm-pull-6" style="height: 500px;">
                     <div class="fb-page" 
                          data-tabs="messages"
                          data-href="https://www.facebook.com/WorldTechnicalElite"
                          data-width="500"
                          data-show-facepile="false"
                          data-adapt-container-width="true" 
                          small_header="true";
                          data-hide-cover="true"
                          >
                          
                    </div>
      <hr>

  </div>          

  
  <div class="col-md-3">
               <div class="panel">
                        <div class="panel-heading" style="background-image:url(images/icons/back.png); background-repeat:repeat-x; color:#000">
                         <strong>من نحن</strong>
                        </div>
                        <div class="panel-body">
                       <div style="text-align:center"> <img src="images/logo.ico"></div>
                       <div style="text-align:justify">
النخبة التقنية العالمية هي احد أهم مراكز التدريب المهني في فلسطين, حيث تقدم النخبة مجموعة من برامج الدبلومات المهنية المصدقة من وزارة العمل الفلسطينية. حيث تأسست النخبة لاتاحة الفرصة امام الشباب لاكتساب المهارات العلمية والفنية للدخول الى سوق العمل.وتعمل النخبة الان في ثلاث محافظات وهي : نابلس , سلفيت , جنين 
                        </div>
                        
                        </div>  

  </div>
  
</div> <!-- end row-->

                   
                    <div class="row">
              <div class="col-sm-12">
                    <div class="panel ">
                        <div class="panel-heading" style="background-image:url(images/icons/back.png); background-repeat:repeat-x; color:#000">
                         <strong>فروعنا</strong>
                        </div>
                        <div class="panel-body">
							<ol>
              <li><strong>نابلس</strong> : مجمع الصابر "ستي سنتر" - الطابق الثامن - 0592911155 </li>              
              <li><strong>جنين</strong> :  دوار الجلبوني - عمارة القمة - الطابق السابع - 0592911156</li>
              <li><strong>سلفيت</strong> :  عمارة الزيتونة الطابق الارضي مقابل بنك فلسطين - 0592911115</li>
                            </ol>
                        </div>
                   </div>
              </div>
          </div>
<!--
<a class="weatherwidget-io" href="https://forecast7.com/ar/31d7735d21/jerusalem/" data-label_1="القدس" data-theme="pure" >القدس</a>
<script>
!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="https://weatherwidget.io/js/widget.min.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","weatherwidget-io-js");
</script>
-->
<?php require_once("footer.php");?>
</div> <!--end global ccontainer --> 
</body>
</html>
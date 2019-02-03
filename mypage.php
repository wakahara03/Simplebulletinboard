<?php
 
  session_start(); 

  if(empty($_SESSION['login'])) header("Location:login.php");

  if (!empty($_FILES)) {
   
    $file = $_FILES['img'];
   
    $msg = '';
    $img_path = '';
   
    include('upload.php'); 
  }
?>
 
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>マイページ</title>
    <link rel="stylesheet" type="text/css" href="stylesheet.css">
  </head>
  <body>
 
    <?php if(!empty($_SESSION['login'])){ ?>
 
      <h2>マイページ</h2>
        
        <p><span class="err_msg"><?php if (!empty($msg)) echo $msg; ?></span></p>
 
        <p>画像をアップロードする</p>
         
        <form method="post" enctype="multipart/form-data">
          <input type="file" name="img">
          <input type="submit" value="画像をアップロード">
        </form>
        
        <?php if (!empty($img_path)) { ?>
          <div class="img_area">
            <p>アップロードした画像</p>
            <img src="<?php echo $img_path; ?>">
          </div>
        <?php } ?>

        <a href="logout.php">ログアウト</a>
 
    <?php } ?>
 
  </body>
</html>

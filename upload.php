<?php
 
if(!empty($file)){
 
    $upload_path = 'images/'.$file['name']; 
    $rst = move_uploaded_file($file['tmp_name'],$upload_path); 
 
    if ($rst){
        $msg = '画像をアップロードしました！';
        $img_path = $upload_path; 
    }else{
        $msg = '画像はアップロード出来ませんでした。';
    }

}else{
  $msg = '画像を選択してください';
}
 
?>

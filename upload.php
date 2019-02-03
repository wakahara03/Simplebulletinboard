<?php
 
if(!empty($file)){
 
    $upload_path = 'images/'.$file['name']; 
    $upload_file = move_uploaded_file($file['tmp_name'],$upload_path); 
 
    if (!empty($upload_file)){
        $msg = '画像をアップロードしました！';
        $img_path = $upload_path; 
    }else{
        $msg = '画像を選択してください';
    }
}
 
?>

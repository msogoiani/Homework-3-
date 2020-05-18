<?php
session_start();
class UploadHelper{
    public $uploaded;
    public $target_file;
     function __construct () {
        $this->target_file = 'images/' . basename($_FILES["image"]["name"]);
        $this->uploaded = 1;
        $this->imageFileType = $_FILES["image"]["type"];
        if(isset($_POST["submit"])) {
            $check = getimagesize($_FILES["image"]["tmp_name"]);
            if($check !== false) {
                echo "File is an pic - " . $check["mime"] . ".";
                $this->uploaded = 1;
            } else {
                echo "File is not a pic.";
                $this->uploaded = 0;
            }
        }
    }
     public function picSize(){
         if ($_FILES["image"]["size"] > 200000) {
             echo "Sorry, your file is too large.";
             $uploaded = 0;
         }
     }
     public function pictype(){
         if( $_FILES["image"]["type"] !== 'image/jpeg') {
             echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
             $uploaded = 0;
         }
     }
    public function Upload(){
        if ($this->uploaded == 0) {
            echo "Sorry, your file was not uploaded.";
        }
        else {
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $this->target_file)) {
                $_SESSION['img']=$this->target_file;
                header("Location: welcometosession.php");
            }
            else {
                echo "Sorry, there was an error uploading your file.";
            }
        } 
    }
}
$pic = new UploadHelper();
$pic->picSize();
$pic->pictype();
$pic->Upload();
?>
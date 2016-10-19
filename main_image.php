<?php include('include/header.php');
$error=false;
$message='';
if(isset($_POST['add_image'])){

    $final_name='';
    $files_names = array();

    //Upload files

    $success=0;


        for ($i = 0; $i < count($_FILES['image']['name']); $i++) {
            $target_dir = "upload/";
            $time_stemp = time();

            if (isset($_FILES["image"]["name"][$i]) && $_FILES["image"]["name"][$i] != '') {

                $name=$_FILES["image"]["name"][$i];
                $ext=strtoupper(pathinfo($name, PATHINFO_EXTENSION));
                $final_name = $time_stemp . rand(111111111, 999999999).'.'. $ext;
                $target_file = $target_dir . $final_name;
                if ($ext == 'PNG' OR $ext == "GIF" OR $ext == "BMP" OR $ext == "JPG") {
                    if (move_uploaded_file($_FILES["image"]["tmp_name"][$i], $target_file)) {

                        $sql = "select * from main_image";
                        $image = $conn->query($sql)->fetch_assoc();
                        if(!empty($image))
                        {
                            if(file_exists('upload/'.$image['image']))
                                unlink('upload/'.$image['image']);
                            $sql = "delete from main_image";
                            $conn->query($sql);
                        }


                        $link=$_POST['link'];
                        $sql = "INSERT INTO main_image (image,link) VALUES ('$final_name','$link')";
                        if ($conn->query($sql)) {
                            $success++;
                        }
                    }
                }
            }
        }

    if($success>0){
        $message = "<p>".$success." Image added successfully.</p>";
    } else {
        $message = "<p> Upload fail</p>";
        $error = true;
    }


}else if(isset($_POST['image_delete']))
{
    $id=$_POST['image_delete'];
    if(file_exists($_POST['url']))
        unlink($_POST['url']);
    $sql = "delete from main_image where id=$id";
    if ($conn->query($sql) === TRUE) {
        $message = "<p>Image Deleted successfully.</p>";
    }
}
common_rediect($message,$error);
?>


<style>
    .pl40px{
        padding-left: 40px;
    }
    .fs20px{
        font-size: 20px;
    }
    .list-style{
        list-style: none;
        border-bottom: 2px solid rgba(169, 166, 166, 0.25);
        margin: 10px 0px;
        padding-left: 9px;
        padding-bottom: 30px;
        font-size: 15px;
    }

</style>



    <div class="container" style="padding-left: 0px;padding-right: 0px;padding: 20px;padding-top: 0px">

        <div class="col-sm-6 " style="padding-top: 10px">
        <h3><b>Image</b></h3>


            <?php common_response($message); ?>

        <form action="" method="post" enctype="multipart/form-data">
            <fieldset class="col-sm-12 mt10">
                <div class="form-group">
                    <div class="col-sm-12 pn" style="margin-top: 10px">
                        <label for="title">Image : </label>
                        <input type="file"   class="form-control  col-sm-8" name="image[]" multiple="multiple">
                    </div>
                    <?php
                    $sql = "select * from main_image ";
                    $image= $conn->query($sql)->fetch_assoc();
                    if (!empty($image)) {?>
                                 <div style="margin: 5px">
                                    <img style="width: 100px" src="upload/<?php echo $image['image'] ?>">
                                    <form style="display: inline;" method="post">
                                        <input type="hidden" value="upload/<?php echo $image['image'] ?>" name="url">
                                        <button name="image_delete"  onclick="javascript:if(confirm('are you sure delete?')==false) return false"   type="submit"  value="<?php echo $image['id'] ?>" ><i class="fa fa-times"></i></button>
                                    </form>
                                </div>

                    <?php }?>
                    <div class="col-sm-12 pn" style="margin-top: 10px">
                        <label for="title">Link : </label>
                        <input type="text"   class="form-control  col-sm-8" name="link" id="link"
                               placeholder="Link" value="<?php echo !empty($image)?$image['link']: '' ?>">
                    </div>

                    <button  type="submit" class="btn btn-primary" style="margin-top: 20px" name="add_image">Save
                    </button>
            </fieldset>
        </form>
</div>


    </div>


<?php include('include/footer.php') ?>



<style>
    .table > thead > tr > th, .table > tbody > tr > th, .table > tfoot > tr > th, .table > thead > tr > td, .table > tbody > tr > td, .table > tfoot > tr > td {
        border-top: none;
    }
</style>

<?php include('include/header.php');
$error=false;
$message='';
if(isset($_POST['add_image'])){

    $final_name='';
    $files_names = array();

    //Upload files

    $success=0;

    $company_id=addslashes($_POST['company_id']);
    if(!empty($company_id)) {
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
                        $sql = "INSERT INTO image (url,company_id) VALUES ('$final_name','$company_id')";
                        if ($conn->query($sql)) {
                            $success++;
                        }
                    }
                }
            }
        }
    }
    if($success>0){
        $message = "<p>".$success." Image added successfully.</p>";
    } else {
        $message = "<p> Upload fail image type not allowed</p>";
        $error = true;
    }


}else if(isset($_POST['image_delete']))
{
    $id=$_POST['image_delete'];
    if(file_exists($_POST['url']))
        unlink($_POST['url']);
    $sql = "delete from image where id=$id";
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


                    <label for="email" style="margin-top: 10px">Select company : </label>
                    <?php
                    $sql = "select * from company order by id";
                    $result = $conn->query($sql);
                    ?>
                    <div class="col-sm-12" style="padding: 0!important;">
                        <div class="col-sm-9" style="display: inline-block;padding: 0!important;margin-bottom: 5px">
                            <select class="form-control" name="company_id" style="display: inline" required id="company-id">
                                <option selected value="">Select</option>
                                <?php if (mysqli_fetch_assoc($result) > 0) {
                                    foreach ($result as $res) {
                                        ?>
                                        <option
                                            value="<?php echo $res['id'] ?>" <?php echo $error && $_POST['company_id'] == $res['id'] ? 'selected' :'' ?>><?php echo $res['name'] ?></option>
                                    <?php }
                                } ?>

                            </select>
                        </div>

                    </div>


                    <div class="col-sm-12 pn" style="margin-top: 10px">
                        <label for="title">Image : </label>
                        <input type="file"  required class="form-control  col-sm-8" name="image[]" multiple="multiple">
                    </div>


                    <button  type="submit" class="btn btn-primary" style="margin-top: 20px" name="add_image">Submit
                    </button>
            </fieldset>
        </form>
</div>
        <?php
        $sql = "select * from company  order by id ";
        $result_company= $conn->query($sql);
        if (mysqli_fetch_assoc($result_company) > 0) {
            foreach ($result_company as $company) {?>
                <h4>company : <?php echo $company['name']  ?></h4>

                    <?php
                    $sql = "select * from image where company_id=".$company['id']." order by id desc";
                    $result_image= $conn->query($sql);
                    if (mysqli_fetch_assoc($result_image) > 0) {?>
                        <div class="grid" style="margin: 0 auto;margin-top: 10px">
                        <?php foreach ($result_image as $image) {?>
                            <div class="grid-item" style="margin: 5px">
                                <img style="width: 100px" src="upload/<?php echo $image['url'] ?>">
                                <form style="display: inline;" method="post">
                                    <input type="hidden" value="http://www.gilbert7.com/projects/kapil/ibc/upload/<?php echo $image['url'] ?>" name="url">
                                    <button name="image_delete"  onclick="javascript:if(confirm('are you sure delete?')==false) return false"   type="submit"  value="<?php echo $image['id'] ?>" ><i class="fa fa-times"></i> </button>
                                </form>
                            </div>
                        <?php }?>
                        </div>
                   <?php }else{?>
                        <div style="width: 100%;text-align: center"><h4>No image found</h4></div>
                    <?php } ?>


            <?php }
        }else{?>
            <div style="width: 100%;text-align: center"><h4>No image found</h4></div>
        <?php } ?>
    </div>


<?php include('include/footer.php') ?>

<script src="assets/js/masonry.pkgd.min.js"></script>
<script>
    $(document).ready(function () {
        $('.grid').masonry({
            // options
            itemSelector: '.grid-item',
            fitWidth: true
        });
       /* $.get(url, data, function (data) {
            $('#report-data').html(data);
            $('.loader').hide();
        });*/
    });
</script>
<style>
    .table > thead > tr > th, .table > tbody > tr > th, .table > tfoot > tr > th, .table > thead > tr > td, .table > tbody > tr > td, .table > tfoot > tr > td {
        border-top: none;
    }
</style>

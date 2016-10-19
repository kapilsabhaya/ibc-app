<?php include('include/header.php');
$datetime=gmdate('Y-m-d H:m:d');
$error = false;
$message = '';
if (isset($_POST['blog_submit'])) {
    if (empty($_POST['title']))
    {
        $message = '<p>Please enter blog title.</p>';
        $error = true;
    }
    if (empty($_POST['description'])) {
        $message .= '<p>Please enter  blog description.</p>';
        $error = true;
    }

    $image='';
    if(!empty($_FILES["image"]["name"])) {
        $target_dir = "upload/";
        $time_stemp = time();

        $name=$_FILES["image"]["name"];
        $ext=strtoupper(pathinfo($name, PATHINFO_EXTENSION));
        $final_name = $time_stemp . rand(111111111, 999999999).'.'. $ext;
        $target_file = $target_dir . $final_name;
        if ($ext == 'PNG' OR $ext == "GIF" OR $ext == "BMP" OR $ext == "JPG") {
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                $image=addslashes($final_name);
            }else{
                $message = '<p>Upload failes.</p>';
                $error = true;
            }
        }else{
            $message = '<p>File type not allowed.</p>';
            $error = true;
        }
    }
    if (!$error ) {
        $title=addslashes(trim($_POST['title']));
        $description = addslashes(trim($_POST['description']));
        $datetime = gmdate('Y-m-d H:m:s');
        if($_POST['blog_submit']=='Add') {
            $sql = "INSERT INTO blog (title,description,image,datetime) VALUES ('$title','$description','$image','$datetime')";
            $action='Added';
        }else{
            $id=addslashes($_POST['id']);
            if(!empty($id)){
                if(!empty($image)){$image=', image="'.$image.'" ';}
                $sql = "update blog set title='$title',description='$description'$image where id=$id";
                $action='Updated';
            }else{
                $message = '<p>Please try again.</p>';
                $error = true;
            }
        }
        if ($conn->query($sql) === TRUE) {
            $message = "<p>blog ".$action." successfully.</p>";
        } else {
            $message = "<p>" . $conn->error.'</p>';
            $error = true;
        }

    }
}else if(isset($_POST['blog_delete']))
{
    $id=$_POST['blog_delete'];
    $sql = "delete from blog where id=$id";
    if ($conn->query($sql) === TRUE) {
        $message = "<p>Blog deleted successfully.</p>";

    }
}else if(isset($_POST['blog_delete_image']))
{
    $id=$_POST['blog_delete_image'];

    $sql = "update blog set image='' where id=$id";
    if ($conn->query($sql) === TRUE) {

        if(is_link($_POST['image_path']))
            unlink($_POST['image_path']);
        $message = "<p>Image deleted successfully.</p>";
    }

}
common_rediect($message,$error);
$datetime=gmdate('Y-m-d H:m:d');
?>




<div class="col-sm-6 " style="padding-top: 10px">
    <h3><b>Blog</b></h3>
    <?php common_response($message); ?>
    <form action="" method="post" id="form" enctype="multipart/form-data">
        <fieldset class="col-sm-12 mt10">
            <div class="form-group">



                <div class="col-sm-12 pn" style="margin-top: 10px">
                    <label for="title">Title : </label>
                    <input type="text"  required class="form-control  col-sm-8" name="title" id="title"
                           placeholder="Title" value="<?php echo $error ? $_POST['title'] : '' ?>">
                </div>


                <div class="col-sm-12 pn" style="margin-top: 10px">
                    <label for="comment">Description</label>
                    <textarea class="form-control" name="description" id="description" rows="5" required placeholder="Description"><?php echo $error ? $_POST['description'] : '' ?></textarea>
                </div>

                <div class="col-sm-12 pn" style="margin-top: 10px">
                    <label for="title">Image : </label>
                    <input type="file"   class="form-control  col-sm-8" name="image" id="file" >
                    <div id="edit-image"> </div>
                </div>

               <!-- <div class="col-sm-8" style="margin-top: 10px;padding-left: 0px">
                    <label for="datetime">Date : </label>
                    <input type="date"  required class="form-control  col-sm-8" name="datetime" id="datetime"
                           value="<?php /*echo $error ? $_POST['datetime'] : '' */?>">
                </div>-->
                <input type="hidden" id="edit-id" value="<?php  echo $error?$_POST['id']:0?>" name="id">
                <input  type="submit" class="btn btn-primary" style="margin-top: 20px" name="blog_submit" value="<?php echo $error&&$_POST['id']!=0?'Update':'Add' ?>" id="submit-btn">
               <input  type="button" class="btn btn-warning" style="margin-top: 20px;<?php  echo $error&&$_POST['id']!=0?'':'display: none'?>" value="Cancel" id="close-btn">
        </fieldset>
    </form>
</div>
<div class="table-responsive">
    <table class="table">

        <thead>
        <tr >
            <th>Image</th>
            <th>Title</th>
            <th>Description</th>
            <th>Datetime</th>
            <th>edit / delete</th>
        </tr>
        </thead>

        <tbody>

        <?php
       // $sql = "select * from blog where concat(date,' ',time) > '$datetime' order by concat(date,' ',time) ";
        $sql = "select * from blog order by id desc";

        $result_blog= $conn->query($sql);
        if (mysqli_fetch_assoc($result_blog) > 0) {
        foreach ($result_blog as $blog) {?>
        <tr>
            <td style="position: relative  ">

                <?php if(!empty($blog['image'] )) {?>
                    <form style="display: inline" method="post" >
                        <a href="upload/<?php echo $blog['image'] ?>" target="_blank"><img src="upload/<?php echo $blog['image'] ?>" width="100px" ></a>
                        <input type="hidden" name="image_path" value="http://www.gilbert7.com/projects/kapil/ibc/upload/<?php echo $blog['image'] ?>">
                        <button style="position: absolute;right: 0;top:0;padding:0" name="blog_delete_image"  onclick="javascript:if(confirm('are you sure delete image?')==false) return false"   type="submit"  value="<?php echo $blog['id'] ?>" ><i class="fa fa-times fa-fw"></i></button>
                    </form>
                <?php }else{
                    echo 'No image found';
                } ?>
            </td>
            <td><?php echo $blog['title'] ?></td>
            <td><?php echo $blog['description'] ?></td>
            <td><?php echo $blog['datetime'] ?></td>

            <td>
                <button type="button"
                   data-title="<?php echo $blog['title'] ?>"
                   data-description="<?php echo $blog['description'] ?>"
                   data-image="upload/<?php echo $blog['image'] ?>"
                   data-datetime="<?php echo $blog['datetime'] ?>"
                   data-id="<?php echo $blog['id'] ?>" class="edit_blog_btn"><i class="fa fa-edit fa-fw"></i></button> /

                <form style="display: inline;" method="post">
                    <button name="blog_delete"  onclick="javascript:if(confirm('are you sure delete?')==false) return false"   type="submit"  value="<?php echo $blog['id'] ?>" ><i class="fa fa-times fa-fw"></i></button>
                </form>
            </td>
        </tr>
        <?php }
        }else{
            ?>
            <tr>
                <td colspan="7" style="text-align: center">No upcoming blogs found</td>
            </tr>
            <?php
        } ?>
        </tbody>





    </table>


</div>

</div>
<?php include('include/footer.php') ?>





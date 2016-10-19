<?php include('include/header.php');
$error=false;
$message='';
if(isset($_POST['youtube_submit'])){
    if(empty($_POST['url']))
    {
        $message .= "<p>Please enter youtube url.</p>";
        $error=true;
    }
    if (!$error) {
        $youtube=$_POST['url'];
        $url = "http://www.youtube.com/oembed?url=".$youtube."&format=json";
        $response = file_get_contents($url);
        $obj = json_decode($response);
        if (!isset($obj->title)) {
            $message .= "<p>Invalid url no Video title found.</p>";
            $error = true;
        }
        if (!$error) {

            $title = addslashes(trim($obj->title));
            $url = addslashes(trim($youtube));
            if (!isset($_POST['date']) || empty($_POST['date'])) {
                $date = gmdate('Y-m-d H:m:s');
            }else{
                $date = addslashes(trim($_POST['date']));
            }
            $thumb_url=isset($obj->thumbnail_url)?addslashes($obj->thumbnail_url):'';
            if ($_POST['youtube_submit'] == 'Add') {
                $sql = "INSERT INTO youtube (title,url,created_on,thumb_url) VALUES ('$title','$url','$date','$thumb_url')";
                $action = 'Added';
            } else {
                $id = addslashes($_POST['id']);
                if (!empty($id)) {
                    $sql = "update youtube set title='$title',url='$url',created_on='$date',thumb_url='$thumb_url' where id=$id";
                    $action = 'Updated';
                } else {
                    $message = '<p>Please try again.</p>';
                    $error = true;
                }
            }

            if ($conn->query($sql) === TRUE) {
                $message = "<p>Youtube " . $action . " successfully.</p>";
            } else {
                $message = "<p>" . $conn->error . '</p>';
                $error = true;
            }
        }
}

}else if(isset($_POST['youtube_delete']))
{
    $id=$_POST['youtube_delete'];
    $sql = "delete from youtube where id=$id";
    if ($conn->query($sql) === TRUE) {
        $message = "<p>Youtube Deleted successfully.</p>";
    }
}
common_rediect($message,$error);
?>





    <div class="container" style="padding-left: 0px;padding-right: 0px;padding: 20px;padding-top: 0px">

        <div class="col-sm-6 " style="padding-top: 10px">
        <h3><b>VIDEO OF THE DAY</b></h3>
            <?php common_response($message); ?>

        <form action="" method="post" enctype="multipart/form-data" id="form">
            <fieldset class="col-sm-12 mt10">
                <div class="form-group">




                    <div class="col-sm-12 pn" style="margin-top: 10px">
                        <label for="title">Youtube : </label>
                        <input type="text"  required class="form-control  col-sm-8" <?php echo $error ? $_POST['url'] : '' ?> id="url" name="url" placeholder="Enter youtube video URL">
                    </div>


                   <!-- <div class="col-sm-8" style="margin-top: 10px;padding-left: 0px">
                        <label for="date">Date : </label>

                        <input type="date"   class="form-control  col-sm-8" name="date" id="date"
                               value="<?php /*echo $error ? $_POST['date'] : '' */?>">
                    </div>-->


                    <input type="hidden" id="edit-id" value="<?php  echo $error?$_POST['id']:0?>" name="id">
                    <input  type="submit" class="btn btn-primary" style="margin-top: 20px" name="youtube_submit" value="<?php echo $error&&$_POST['id']!=0?'Update':'Add' ?>" id="submit-btn">
                    <input  type="button" class="btn btn-warning" style="margin-top: 20px;<?php  echo $error&&$_POST['id']!=0?'':'display: none'?>" value="Cancel" id="close-btn">

            </fieldset>
        </form>
</div>

        <div class="table-responsive">
            <table class="table">

                <thead>
                <tr >
                    <th>Title</th>
                    <th>Created on</th>
                    <th>Url</th>

                </tr>
                </thead>

                <tbody>

                <?php
                // $sql = "select * from youtube where concat(date,' ',time) > '$datetime' order by concat(date,' ',time) ";
                $sql = "select * from youtube order by id desc";

                $result_youtube= $conn->query($sql);
                if (mysqli_fetch_assoc($result_youtube) > 0) {
                    foreach ($result_youtube as $youtube) {?>
                        <tr>
                            <td><?php echo $youtube['title'] ?></td>
                            <td><?php echo $youtube['created_on'] ?></td>
                            <td><a href="<?php echo $youtube['url'] ?>" target="_blank"><?php echo $youtube['url'] ?></a> </td>
                            <td><img src="<?php echo $youtube['thumb_url'] ?>" width="100px"></td>
                           <td>
                                <button type="button"
                                        data-date="<?php echo $youtube['created_on'] ?>"
                                        data-url="<?php echo $youtube['url'] ?>"
                                        data-id="<?php echo $youtube['id'] ?>"
                                        class="edit_youtube_btn"><i class="fa fa-edit fa-fw"></i></button> /
                                <form style="display: inline;" method="post">
                                    <button name="youtube_delete"  onclick="javascript:if(confirm('are you sure delete?')==false) return false"   type="submit"  value="<?php echo $youtube['id'] ?>" ><i class="fa fa-times fa-fw"></i></button>
                                </form>
                            </td>
                        </tr>
                    <?php }
                }else{
                    ?>
                    <tr>
                        <td colspan="7" style="text-align: center">No youtube found</td>
                    </tr>
                    <?php
                } ?>
                </tbody>





            </table>


        </div>
    </div>


<?php include('include/footer.php') ?>





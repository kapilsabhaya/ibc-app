<?php include('include/header.php') ?>
<?php

$error = false;
$message = '';
if (isset($_POST['verse_submit'])) {


    if (empty($_POST['title'])) {
        $message = '<p>Please enter Verse.</p>';
        $error = true;
    }
    if (empty($_POST['message'])) {
        $message = '<p>Please enter message.</p>';
        $error = true;
    }

    if (!isset($_POST['date']) || empty($_POST['date'])) {
        $date = date('Y-m-d H:m:s');
    }else{
        $date = addslashes(trim($_POST['date']));
    }

    if (!$error) {
        $title=addslashes(trim($_POST['title']));
        $message = addslashes(trim($_POST['message']));

        if($_POST['verse_submit']=='Add') {
            $sql = "INSERT INTO verse (title,message,date) VALUES ('$title','$message','$date')";
            $action='Added';
        }else{
            $id=addslashes($_POST['id']);
            if(!empty($id)){
                $sql = "update verse set title='$title',message='$message',date='$date' where id=$id";
                $action='Updated';
            }else{
                $message = '<p>Please try again.</p>';
                $error = true;
            }
        }
        if ($conn->query($sql) === TRUE) {
            $message = "<p>verse ".$action." successfully.</p>";
        } else {
            $message = "<p>" . $conn->error.'</p>';
            $error = true;
        }

    }
}else if(isset($_POST['verse_delete']))
{
    $id=$_POST['verse_delete'];

    $sql = "delete from verse where id=$id";
    if ($conn->query($sql) === TRUE) {
        $message = "<p>Verse deleted successfully.</p>";
    }
}
common_rediect($message,$error);
$datetime=gmdate('Y-m-d H:m:d');
?>




<div class="col-sm-6 " style="padding-top: 10px">
    <h3><b>verse</b></h3>


    <?php common_response($message); ?>

    <form action="" method="post" id="form">
        <fieldset class="col-sm-12 mt10">
            <div class="form-group">



                <div class="col-sm-12 pn" style="margin-top: 10px">
                    <label for="title">Verse : </label>
                    <input type="text"  required class="form-control  col-sm-8" name="title" id="title"
                           placeholder="Verse" value="<?php echo $error ? $_POST['title'] : '' ?>">
                </div>

                <div class="col-sm-12 pn" style="margin-top: 10px">
                    <label for="message">Message</label>
                    <textarea class="form-control" name="message" id="message" rows="7" required placeholder="Message"><?php echo $error ? $_POST['message'] : '' ?></textarea>
                </div>


                <div class="col-sm-8" style="margin-top: 10px;padding-left: 0px">
                    <label for="date">Date : </label>

                    <input type="datetime-local"   class="form-control  col-sm-8" name="date" id="date"
                            value="<?php echo $error ? $_POST['date'] : '' ?>" >
                </div>




                <input type="hidden" id="edit-id" value="<?php  echo $error?$_POST['id']:0?>" name="id">
                <input  type="submit" class="btn btn-primary" style="margin-top: 20px" name="verse_submit" value="<?php echo $error&&$_POST['id']!=0?'Update':'Add' ?>" id="submit-btn">
               <input  type="button" class="btn btn-warning" style="margin-top: 20px;<?php  echo $error&&$_POST['id']!=0?'':'display: none'?>" value="Cancel" id="close-btn">
        </fieldset>
    </form>
</div>
<div class="table-responsive">
    <table class="table">

        <thead>
        <tr >
            <th>Verse</th>
            <th>Message</th>
            <th>Date</th>
            <th>edit / delete</th>
        </tr>
        </thead>

        <tbody>

        <?php
       // $sql = "select * from verse where concat(date,' ',time) > '$datetime' order by concat(date,' ',time) ";
        $sql = "select * from verse order by date desc ";

        $result_verse= $conn->query($sql);
        if (mysqli_fetch_assoc($result_verse) > 0) {
        foreach ($result_verse as $verse) {?>
        <tr>

            <td><?php echo $verse['title'] ?></td>
            <td><?php echo $verse['message'] ?></td>
            <td><?php echo $verse['date'] ?></td>

            <td>
                <button type="button"
                   data-title="<?php echo $verse['title'] ?>"
                   data-message="<?php echo $verse['message'] ?>"
                   data-date="<?php echo $verse['date'] ?>"
                   data-id="<?php echo $verse['id'] ?>" class="edit_verse_btn"><i class="fa fa-edit fa-fw"></i></button> /

                <form style="display: inline;" method="post">
                    <button name="verse_delete"  onclick="javascript:if(confirm('are you sure delete?')==false) return false"   type="submit"  value="<?php echo $verse['id'] ?>" ><i class="fa fa-times fa-fw"></i></button>
                </form>
            </td>
        </tr>
        <?php }
        }else{
            ?>
            <tr>
                <td colspan="7" style="text-align: center">No verses found</td>
            </tr>
            <?php
        } ?>
        </tbody>





    </table>


</div>

</div>
<?php include('include/footer.php') ?>





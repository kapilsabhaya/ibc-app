<?php include('include/header.php') ?>
<?php
$datetime=gmdate('Y-m-d H:m:d');
$sql = "update event set deleted=1 where concat(date,' ',time)<'$datetime'";
$conn->query($sql);
$error = false;
$message = '';
if (isset($_POST['event_submit'])) {


    if (empty($_POST['title'])) {
        $message = '<p>Please enter event title.</p>';
        $error = true;
    }
    if (empty($_POST['time'])) {
        $message .= '<p>Please enter valid event time.</p>';
        $error = true;
    }
    if (empty($_POST['date'])) {
        $message = '<p>Please select event date.</p>';
        $error = true;
    }
    if (empty($_POST['address'])) {
        $message = '<p>Please enter event address.</p>';
        $error = true;
    }
    if (empty($_POST['city'])) {
        $message = '<p>Please enter event city.</p>';
        $error = true;
    }
    if (empty($_POST['state'])) {
        $message = '<p>Please enter event state.</p>';
        $error = true;
    }
    if (empty($_POST['company_id'])) {
        $message = '<p>Please select comapny.</p>';
        $error = true;
    }
    if (empty($_POST['pincode'])) {
        $message = '<p>Please enter Zip code.</p>';
        $error = true;
    }
    if (empty($_POST['country'])) {
        $message = '<p>Please enter country.</p>';
        $error = true;
    }

    if (!$error) {
        $title=addslashes(trim($_POST['title']));
        $time = trim($_POST['time']);
        $date = $_POST['date'];
        $address = addslashes(trim($_POST['address']));
        $city = addslashes(trim($_POST['city']));
        $state = addslashes(trim($_POST['state']));
        $pincode = addslashes(trim($_POST['pincode']));
        $country = addslashes(trim($_POST['country']));
        $company_id=addslashes(trim($_POST['company_id']));
        $redirect=addslashes('https://www.google.com/maps/search/'.$address.' '.$city.' '.$state.' '.$pincode.' '.$country);
        if($_POST['event_submit']=='Add') {
            $sql = "INSERT INTO event (title,time,date,address,city,state,pincode,redirect,country,company_id) VALUES ('$title','$time','$date','$address','$city','$state','$pincode','$redirect','$country','$company_id')";
            $action='Added';
        }else{
            $id=addslashes($_POST['id']);
            if(!empty($id)){
                $sql = "update event set title='$title',time='$time',date='$date',address='$address',city='$city',state='$state',pincode='$pincode',redirect='$redirect',country='$country',company_id='$company_id' where id=$id";
                $action='Updated';
            }else{
                $message = '<p>Please try again.</p>';
                $error = true;
            }
        }
        if ($conn->query($sql) === TRUE) {
            $message = "<p>Event ".$action." successfully.</p>";
        } else {
            $message = "<p>" . $conn->error.'</p>';
            $error = true;
        }

    }
}else if(isset($_POST['event_delete']))
{
    $id=$_POST['event_delete'];

    $sql = "delete from event where id=$id";
    if ($conn->query($sql) === TRUE) {
        $message = "<p>Event Deleted successfully.</p>";
    }
}
common_rediect($message,$error);
$datetime=gmdate('Y-m-d H:m:d');
?>




<div class="col-sm-6 " style="padding-top: 10px">
    <h3><b>Event</b></h3>

    <?php common_response($message); ?>

    <form action="" method="post" id="form">
        <fieldset class="col-sm-12 mt10">
            <div class="form-group">



                <div class="col-sm-12 pn" style="margin-top: 10px">
                    <label for="title">Title : </label>
                    <input type="text"  required class="form-control  col-sm-8" name="title" id="title"
                           placeholder="Title" value="<?php echo $error ? $_POST['title'] : '' ?>">
                </div>

                <div class="col-sm-12 pn" style="margin-top: 10px">
                    <label for="title">Time : </label>
                    <input type="time"  required class="form-control decimal col-sm-8" name="time" id="time"
                           placeholder="Time" value="<?php echo $error ? $_POST['time'] : '' ?>">
                </div>


                <div class="col-sm-8" style="margin-top: 10px;padding-left: 0px">
                    <label for="date">Date : </label>

                    <input type="date"  required class="form-control  col-sm-8" name="date" id="date"
                            value="<?php echo $error ? $_POST['date'] : '' ?>">
                </div>


                <label for="email" style="margin-top: 10px">Select department : </label>
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
                    <label for="comment">Address</label>
                    <textarea class="form-control" name="address" id="address" rows="5" required placeholder="Address"><?php echo $error ? $_POST['address'] : '' ?></textarea>
                </div>

                <div class="col-sm-12 pn" style="margin-top: 10px">
                    <label for="title">City : </label>
                    <input type="text"  required class="form-control  col-sm-8" name="city" id="city"
                           placeholder="City" value="<?php echo $error ? $_POST['city'] : '' ?>">
                </div>
                <div class="col-sm-12 pn" style="margin-top: 10px">
                    <label for="title">State : </label>
                    <input type="text"  required class="form-control  col-sm-8" name="state" id="state"
                           placeholder="State" value="<?php echo $error ? $_POST['state'] : '' ?>">
                </div>
                <div class="col-sm-12 pn" style="margin-top: 10px">
                    <label for="title">Zip code : </label>
                    <input type="text"  required class="form-control  col-sm-8" name="pincode" id="pincode"
                           placeholder="Zip code" value="<?php echo $error ? $_POST['pincode'] : '' ?>">
                </div>
                <div class="col-sm-12 pn" style="margin-top: 10px">
                    <label for="title">Country : </label>
                    <input type="text"  required class="form-control  col-sm-8" name="country" id="country"
                           placeholder="Country" value="<?php echo $error ? $_POST['country'] : '' ?>">
                </div>

                <input type="hidden" id="edit-id" value="<?php  echo $error?$_POST['id']:0?>" name="id">
                <input  type="submit" class="btn btn-primary" style="margin-top: 20px" name="event_submit" value="<?php echo $error&&$_POST['id']!=0?'Update':'Add' ?>" id="submit-btn">
               <input  type="button" class="btn btn-warning" style="margin-top: 20px;<?php  echo $error&&$_POST['id']!=0?'':'display: none'?>" value="Cancel" id="close-btn">
        </fieldset>
    </form>
</div>
<div class="table-responsive">
    <table class="table">

        <thead>
        <tr >
            <th>Company</th>
            <th>Title</th>
            <th>date time</th>
            <th>address</th>
            <th>city</th>
            <th>state</th>
            <th>pincode</th>
            <th>country</th>
            <th>redirect</th>
            <th>edit / delete</th>
        </tr>
        </thead>

        <tbody>

        <?php
       // $sql = "select * from event where concat(date,' ',time) > '$datetime' order by concat(date,' ',time) ";
        $sql = "select e.*,c.name  from event e,company c where c.id=e.company_id  order by concat(e.date,' ',e.time) desc";

        $result_event= $conn->query($sql);
        if (mysqli_fetch_assoc($result_event) > 0) {
        foreach ($result_event as $event) {?>
        <tr>
            <td><?php echo $event['name'] ?></td>
            <td><?php echo $event['title'] ?></td>
            <td><?php echo $event['date'].' '.$event['time'] ?></td>
            <td><?php echo $event['address'] ?></td>
            <td><?php echo $event['city'] ?></td>
            <td><?php echo $event['state'] ?></td>
            <td><?php echo $event['pincode'] ?></td>
            <td><?php echo $event['country'] ?></td>
            <td><a href="<?php echo $event['redirect']?>" target="_blank">Map url</a> </td>

            <td>
                <button type="button"
                   data-title="<?php echo $event['title'] ?>"
                   data-time="<?php echo $event['time'] ?>"
                   data-date="<?php echo $event['date'] ?>"
                   data-address="<?php echo $event['address'] ?>"
                   data-city="<?php echo $event['city'] ?>"
                   data-state="<?php echo $event['state'] ?>"
                   data-redirect="<?php echo $event['redirect'] ?>"
                   data-pincode="<?php echo $event['pincode'] ?>"
                   data-country="<?php echo $event['country'] ?>"
                   data-company-id="<?php echo $event['company_id'] ?>"
                   data-id="<?php echo $event['id'] ?>" class="edit_event_btn"><i class="fa fa-edit fa-fw"></i></button> /

                <form style="display: inline;" method="post">
                    <button name="event_delete"  onclick="javascript:if(confirm('are you sure delete?')==false) return false"   type="submit"  value="<?php echo $event['id'] ?>" ><i class="fa fa-times fa-fw"></i></button>
                </form>
            </td>
        </tr>
        <?php }
        }else{
            ?>
            <tr>
                <td colspan="7" style="text-align: center">No upcoming events found</td>
            </tr>
            <?php
        } ?>
        </tbody>





    </table>


</div>

</div>
<?php include('include/footer.php') ?>





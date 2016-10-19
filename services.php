<?php include('include/header.php') ?>
<?php
$datetime=gmdate('Y-m-d H:m:d');
$error = false;
$message = '';
if (isset($_POST['services_submit'])) {


    if (empty($_POST['title'])) {
        $message = '<p>Please enter services title.</p>';
        $error = true;
    }
    if (empty($_POST['time'])) {
        $message .= '<p>Please enter valid services time.</p>';
        $error = true;
    }
    if (empty($_POST['address'])) {
        $message = '<p>Please enter services address.</p>';
        $error = true;
    }
    if (empty($_POST['company_id'])) {
        $message = '<p>Please select company.</p>';
        $error = true;
    }
    if (empty($_POST['repeat_by'])) {
        $message = '<p>Please select services repeat by.</p>';
        $error = true;
    }
    if (empty($_POST['start_on'])) {
        $message = '<p>Please select services start on date.</p>';
        $error = true;
    }
    if (!$error) {
        $title=addslashes(trim($_POST['title']));
        $time = trim($_POST['time']);
        $address = addslashes(trim($_POST['address']));
        $city = addslashes(trim($_POST['city']));
        $state = addslashes(trim($_POST['state']));
        $pincode = addslashes(trim($_POST['pincode']));
        $country = addslashes(trim($_POST['country']));
        $repeat_by = addslashes(trim($_POST['repeat_by']));
        $start_on = $_POST['start_on'];
        $company_id=$_POST['company_id'];
        $redirect=addslashes('https://www.google.com/maps/search/'.$address.' '.$city.' '.$state.' '.$pincode.' '.$country);

        if($_POST['services_submit']=='Add') {
            $sql = "INSERT INTO services (title,time,address,city,state,pincode,redirect,country,repeat_by,start_on,company_id) VALUES ('$title','$time','$address','$city','$state','$pincode','$redirect','$country','$repeat_by','$start_on','$company_id')";
            $action='Added';
        }else{
            $id=addslashes($_POST['id']);
            if(!empty($id)){
                $sql = "update services set title='$title',time='$time',start_on='$start_on',address='$address',repeat_by='$repeat_by',company_id='$company_id' where id=$id";
                $action='Updated';
            }else{
                $message = '<p>Please try again.</p>';
                $error = true;
            }
        }
        if ($conn->query($sql) === TRUE) {
            $message = "<p>services ".$action." successfully.</p>";
        } else {
            $message = "<p>" . $conn->error.'</p>';
            $error = true;
        }

    }
}else if(isset($_POST['services_delete']))
{
    $id=$_POST['services_delete'];

    $sql = "delete from services where id=$id";
    if ($conn->query($sql) === TRUE) {
        $message = "<p>services Deleted successfully.</p>";
    }
}
common_rediect($message,$error);
$datetime=gmdate('Y-m-d H:m:d');
?>




<div class="col-sm-6 " style="padding-top: 10px">
    <h3><b>services</b></h3>


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


                <label for="email" style="margin-top: 10px">Repeat : </label>
                <div class="col-sm-12" style="padding: 0!important;">
                    <div class="col-sm-9" style="display: inline-block;padding: 0!important;margin-bottom: 5px">
                        <select class="form-control" name="repeat_by" style="display: inline" required id="repeat_by">
                            <option selected value="">Select</option>
                            <option value="Never" <?php echo isset($_POST)&&$_POST['repeat']=='Never'?'selected':'' ?>>Never</option>
                            <option value="Every Day" <?php echo isset($_POST)&&$_POST['repeat']=='Every Day'?'selected':'' ?>>Every Day</option>
                            <option value="Every Week" <?php echo isset($_POST)&&$_POST['repeat']=='Every Week'?'selected':'' ?>>Every Week</option>
                            <option value="Every 2 Weeks" <?php echo isset($_POST)&&$_POST['repeat']=='Every 2 Weeks'?'selected':'' ?>>Every 2 Weeks</option>
                            <option value="Every Month" <?php echo isset($_POST)&&$_POST['repeat']=='Every Month'?'selected':'' ?>>Every Month</option>
                            <option value="Every Year" <?php echo isset($_POST)&&$_POST['repeat']=='Every Year'?'selected':'' ?>>Every Year</option>
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

                <div class="col-sm-8" style="margin-top: 10px;padding-left: 0px">
                    <label for="date">Start on : </label>
                    <input type="date"  required class="form-control  col-sm-8" name="start_on" id="start_on"
                           value="<?php echo $error ? $_POST['start_on'] : '' ?>">
                </div>
                <input type="hidden" id="edit-id" value="<?php  echo $error?$_POST['id']:0?>" name="id">
                <input  type="submit" class="btn btn-primary" style="margin-top: 20px" name="services_submit" value="<?php echo $error&&$_POST['id']!=0?'Update':'Add' ?>" id="submit-btn">
               <input  type="button" class="btn btn-warning" style="margin-top: 20px;<?php  echo $error&&$_POST['id']!=0?'':'display: none'?>" value="Cancel" id="close-btn">
        </fieldset>
    </form>
</div>
<div class="table-responsive">
    <table class="table">

        <thead>
        <tr >
            <th>Department</th>
            <th>Title</th>
            <th>Time</th>
            <th>Address</th>
            <th>Repeat</th>
            <th>Starts on</th>
            <th>Map link</th>
            <th>edit / delete</th>
        </tr>
        </thead>

        <tbody>

        <?php
       // $sql = "select * from services where concat(date,' ',time) > '$datetime' order by concat(date,' ',time) ";
        $sql = "select s.*,c.name as name from services s,company c where s.company_id=c.id order by s.id desc";

        $result_services= $conn->query($sql);
        if (mysqli_fetch_assoc($result_services) > 0) {
        foreach ($result_services as $services) {?>
        <tr>
            <td><?php echo $services['name'] ?></td>
            <td><?php echo $services['title'] ?></td>
            <td><?php echo $services['time'] ?></td>
            <td><?php echo $services['address'] ?></td>
            <td><?php echo $services['repeat_by'] ?></td>
            <td><?php echo $services['start_on'] ?></td>
            <td><a href="<?php echo $services['redirect']?>" target="_blank">Map url</a> </td>

            <td>
                <button type="button"
                   data-title="<?php echo $services['title'] ?>"
                   data-time="<?php echo $services['time'] ?>"
                   data-address="<?php echo $services['address'] ?>"
                   data-repeat-by="<?php echo $services['repeat_by'] ?>"
                   data-start-on="<?php echo $services['start_on'] ?>"
                   data-company-id="<?php echo $services['company_id'] ?>"
                        data-city="<?php echo $services['city'] ?>"
                        data-state="<?php echo $services['state'] ?>"
                        data-pincode="<?php echo $services['pincode'] ?>"
                        data-country="<?php echo $services['country'] ?>"
                   data-id="<?php echo $services['id'] ?>" class="edit_services_btn"><i class="fa fa-edit fa-fw"></i></button> /

                <form style="display: inline;" method="post">
                    <button name="services_delete"  onclick="javascript:if(confirm('are you sure delete?')==false) return false"   type="submit"  value="<?php echo $services['id'] ?>" ><i class="fa fa-times fa-fw"></i></button>
                </form>
            </td>
        </tr>
        <?php }
        }else{
            ?>
            <tr>
                <td colspan="7" style="text-align: center">No upcoming servicess found</td>
            </tr>
            <?php
        } ?>
        </tbody>





    </table>


</div>

</div>
<?php include('include/footer.php') ?>





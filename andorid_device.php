<?php
include('include/header.php');

?>
<div class="col-sm-6 " style="padding-top: 10px">
    <h3><b>Android device registration</b></h3>
    <table>
    <?php
        $sql = "select registration_id from android_device";
        $result = $conn->query($sql);
        $registrationIds=array();
        if (mysqli_fetch_assoc($result) > 0) {
            foreach ($result as $res) {
               ?>
                <tr style="border-bottom:1px solid">
                    <td>
                        <?php echo $res['registration_id'] ?>
                    </td>
                </tr>
                <?php
            }
        }else{
            echo 'No device registered';
        }
    ?>
    </table>
</div>


<?php include('include/footer.php') ?>
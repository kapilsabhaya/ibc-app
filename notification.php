<?php
include('include/header.php');
if($_POST['send_notification']){
function send_notification($tokens,$message){
    $url='https://fcm.googleapis.com/fcm/send';
    $fields = array
    (
        'registration_ids' 	=> $tokens,
        'data'			=> $message
    );
    $headers = array
    (
        'Authorization: key=' . API_ACCESS_KEY,
        'Content-Type: application/json'
    );
    $ch = curl_init();
    curl_setopt( $ch,CURLOPT_URL, $url);
    curl_setopt( $ch,CURLOPT_POST, true );
    curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
    curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
    curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
    curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
    $result = curl_exec($ch );
    curl_close( $ch );
    echo $result;
}
define( 'API_ACCESS_KEY', 'AIzaSyBeF0iYvTXLlQoef-Qm7x2rhC2fj2TyvFQ');
 $sql = "select registration_id from android_device";
 $result = $conn->query($sql);
 $registrationIds=array();
 if (mysqli_fetch_assoc($result) > 0) {
    foreach ($result as $res) {
           $registrationIds[]=$res;
    }
    // prep the bundle
    $msg = array
    (
        'message' 	=> $_POST['message'],
        'title'		=> $_POST['title'],
        'subtitle'	=> 'This is a subtitle. subtitle',
        'tickerText'	=> 'Ticker text here...Ticker text here...Ticker text here',
        'vibrate'	=> 1,
        'sound'		=> 1,
        'largeIcon'	=> 'large_icon',
        'smallIcon'	=> 'small_icon'
    );
    
    send_notification($registrationIds,$msg);
 }
}
common_rediect($message,$error);

?>
<div class="col-sm-6 " style="padding-top: 10px">
    <h3><b>Notifications</b> </h3>
    <a href="andorid_device.php" target="_blank">Android device</a>

    <?php common_response($message); ?>

<form action="" method="post" id="form">
    <fieldset class="col-sm-12 mt10">
        <div class="form-group">



            <div class="col-sm-12 pn" style="margin-top: 10px">
                <label for="title">Title : </label>
                <input type="text"  required class="form-control  col-sm-8" name="title" id="title"
                       placeholder="Title">
            </div>

            <div class="col-sm-12 pn" style="margin-top: 10px">
                <label for="comment">Address</label>
                <textarea class="form-control" name="message" id="message" rows="5" required placeholder="Message"></textarea>
            </div>


            <input  type="submit" class="btn btn-primary" style="margin-top: 20px" name="send_notification" value="Send" id="submit-btn">
            <input  type="button" class="btn btn-warning" style="margin-top: 20px;<?php  echo $error&&$_POST['id']!=0?'':'display: none'?>" value="Cancel" id="close-btn">
    </fieldset>
</form>
</div>

</div>
<?php include('include/footer.php') ?>
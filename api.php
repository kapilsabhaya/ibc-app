<?php include('include/db_connection.php');

if(isset($_REQUEST['func']) && $_REQUEST['func']=='upcoming_event')
{

    $datetime=gmdate('Y-m-d H:m:d');
    $where='';
    if(isset($_REQUEST['department']) && !empty($_REQUEST['department']))
    {
        $where=' and company_id='.addslashes($_REQUEST['department']);
    }
    $sql = "select *,c.name as department from event e, company c where e.company_id=c.id and concat(date,' ',time) >= '$datetime' ".$where." order by concat(date,' ',time)";
    $response=array();
    $result_event= $conn->query($sql);
    if (mysqli_fetch_assoc($result_event) > 0) {
        foreach($result_event as $result)
        {
            $response[]=$result;
        }
    }
    die(json_encode($response));
}
else if(isset($_REQUEST['func']) && $_REQUEST['func']=='image' )
{
    $where='';
    if(isset($_REQUEST['department']) && !empty($_REQUEST['department']))
    {
        $where=' and company_id='.addslashes($_REQUEST['department']);
    }
    $sql = "select concat('http://www.gilbert7.com/projects/kapil/ibc/upload/',url) as image_path,c.name as department from image i,company c where i.company_id=c.id ".$where." order by i.id desc";
    $response=array();
    $result_event= $conn->query($sql);
    if (mysqli_fetch_assoc($result_event) > 0) {
        foreach($result_event as $result)
        {
            $response[]=$result;
        }
    }
    die(json_encode($response));
}
else if(isset($_REQUEST['func']) && $_REQUEST['func']=='main_image')
{

    $sql = "select concat('http://www.gilbert7.com/projects/kapil/ibc/upload/',image) as image_path from main_image order by id desc";
    $response=array();
    $result_event= $conn->query($sql);
    if (mysqli_fetch_assoc($result_event) > 0) {
        foreach($result_event as $result)
        {
            $response[]=$result['image_path'];
        }
    }
    die(json_encode($response));
}
else if(isset($_REQUEST['func']) && $_REQUEST['func']=='blog')
{

    $sql = "select title,description,datetime,concat('http://www.gilbert7.com/projects/kapil/ibc/upload/',image) as image_path from blog order by datetime desc";
    $response=array();
    $result_event= $conn->query($sql);
    if (mysqli_fetch_assoc($result_event) > 0) {
        foreach($result_event as $result)
        {
            $response[]=$result;
        }
    }
    die(json_encode($response));
}
else if(isset($_REQUEST['func']) && $_REQUEST['func']=='services')
{
    $where='';
    if(isset($_REQUEST['department']) && !empty($_REQUEST['department']))
    {
        $where=' and company_id='.addslashes($_REQUEST['department']);
    }
    $sql = "select s.*,c.name as department from services s,company c where s.company_id=c.id ".$where."  order by s.id desc";
    $response=array();
    $result_event= $conn->query($sql);
    if (mysqli_fetch_assoc($result_event) > 0) {
        foreach($result_event as $result)
        {
            $response[]=$result;
        }
    }
    die(json_encode($response));
}
else if(isset($_REQUEST['func']) && $_REQUEST['func']=='weekly_services')
{
    $where='';
    if(isset($_REQUEST['department']) && !empty($_REQUEST['department']))
    {
        $where=' and company_id='.addslashes($_REQUEST['department']);
    }
    $sql = "select s.*,c.name as department from services s,company c where s.company_id=c.id and repeat_by='Every Week' ".$where."  order by s.id desc";
    $response=array();
    $result_event= $conn->query($sql);
    if (mysqli_fetch_assoc($result_event) > 0) {
        foreach($result_event as $result)
        {
            $response[]=$result;
        }
    }
    die(json_encode($response));
}
else if(isset($_REQUEST['func']) && $_REQUEST['func']=='device_registration')
{
    $response['status']=false;
    if(isset($_REQUEST['registration_id']) && !empty($_REQUEST['registration_id']))
    {
        $registration_id=$_REQUEST['registration_id'];
        $sql = "insert into android_device (registration_id) values('$registration_id')";
        $result_event= $conn->query($sql);
        if ($result_event) {
            $response['status']=true;
        }else{
            $response['error']=$conn->error;
        }
    }
    die(json_encode($response));
}
else if(isset($_REQUEST['func']) && $_REQUEST['func']=='latest_verse')
{
    $sql = "select * from verse  order by date desc limit 1";
    $response=array();
    $result_verse= $conn->query($sql);
    if (mysqli_fetch_assoc($result_verse) > 0) {
        foreach($result_verse as $result)
        {
            $response[]=$result;
        }
    }
    die(json_encode($response));
}
else if(isset($_REQUEST['func']) && $_REQUEST['func']=='all_verse')
{
    $sql = "select * from verse  order by date desc";
    $response=array();
    $result_verse= $conn->query($sql);
    if (mysqli_fetch_assoc($result_verse) > 0) {
        foreach($result_verse as $result)
        {
            $response[]=$result;
        }
    }
    die(json_encode($response));
}
else if(isset($_REQUEST['func']) && $_REQUEST['func']=='video_of_the_day')
{
    $sql = "select * from youtube  order by created_on desc limit 1";
    $response=array();
    $result_verse= $conn->query($sql);
    if (mysqli_fetch_assoc($result_verse) > 0) {
        foreach($result_verse as $result)
        {
            $response[]=$result;
        }
    }
    die(json_encode($response));
}
else if(isset($_REQUEST['func']) && $_REQUEST['func']=='video_history_list')
{
    $sql = "select * from youtube  order by created_on desc";
    $response=array();
    $result_verse= $conn->query($sql);
    if (mysqli_fetch_assoc($result_verse) > 0) {
        foreach($result_verse as $result)
        {
            $response[]=$result;
        }
    }
    die(json_encode($response));
}
else if(isset($_REQUEST['func']) && $_REQUEST['func']=='department')
{
    $sql = "select id as department_id,name as department from company  order by id";
    $response=array();
    $result_verse= $conn->query($sql);
    if (mysqli_fetch_assoc($result_verse) > 0) {
        foreach($result_verse as $result)
        {
            $response[]=$result;
        }
    }
    die(json_encode($response));
}
else if(isset($_REQUEST['func']) && $_REQUEST['func']=='send_notification')
{
    function send_notification($tokens,$message){
        $url='https://fcm.googleapis.com/fcm/send';
        $fields = array
        (
            'registration_ids' 	=> $tokens,
            'data'			=> $message
        );
        $headers = array
        (
            'Authorization: key=AIzaSyBeF0iYvTXLlQoef-Qm7x2rhC2fj2TyvFQ',
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
        die($result);
    }
    $sql = "select registration_id from android_device where deleted=0";
    $result = $conn->query($sql);
    $registrationIds=array();
    if (mysqli_fetch_assoc($result) > 0) {
        foreach ($result as $res) {
            $registrationIds[]=$res;
        }
        // prep the bundle
        $msg = array
        (
            'message' 	=> 'This is a message. message',
            'title'		=> 'This is a title. title',
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
?>
<!DOCTYPE HTML>
<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html">
<title>Jon's Fake Email Sender</title>
<link href="css/style.css" rel="stylesheet" type="text/css">
<meta charset="UTF-8">
</head>

<body>

<?php
session_start();
$f_Submit = $_POST['submit'];
if ($f_Submit == 'Send')
{
if (strcmp(md5(filter_var($_POST['user_code'],FILTER_SANITIZE_STRING)),$_SESSION['ckey']))
    { 

    $header = "Location: ".basename ( __FILE__,"php")."php?msg=ERROR: Invalid Verification Code";
    header($header);
exit();
  }
    //------------------ Sanitizin the Input Variables NO SANITIZE ------------------//
    $f_fromname   = $_POST['fromname'];
    $f_fromemail  = $_POST['fromemail'];
    $f_reply      = $_POST['reply'];
    $f_toemail    = $_POST['toemail'];
    $f_bccemail   = $_POST['bccemail'];
    $f_subject    = $_POST['subject'];
    $f_message    = $_POST['message'];
    $f_clno       = $_POST['clno'];
    //-------------------------------------------------------------------//
    
    if($f_message=="") {
        $f_message = '
            <html>
            <head>
            <meta charset="UTF-8">
            </head>
            <body bgcolor="#DCEEFC">
            Dear sir,</br>
            your email is compromised.
            </body>
            </html>
            ';
    }

    if($f_reply=="") {
        $f_reply = $f_fromemail;
    }

// Header
    $headers = 'From:'.$f_fromname.' '.'<'.$f_fromemail.'>'. "\r\n";
    $headers .= 'Bcc: '.$f_bccemail. "\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
/*
// Create a boundary so we know where to look for
// the start of the data
    $boundary = uniqid("HTMLEMAIL"); 
    
// First we send a non-html version of our email
    $headers .= "Content-Type: multipart/alternative;".
                "boundary = $boundary\r\n\r\n"; 
    $headers .= "This is a MIME encoded message.\r\n\r\n"; 
    $headers .= "--$boundary\r\n".
                "Content-Type: text/plain; charset=UTF-8\r\n".
                "Content-Transfer-Encoding: base64\r\n\r\n"; 
    $headers .= chunk_split(base64_encode(strip_tags($f_message)));  //$HTML

// Now we attach the HTML version
    $headers .= "--$boundary\r\n".
                "Content-Type: text/html; charset=UTF-8\r\n".
                "Content-Transfer-Encoding: base64\r\n\r\n"; 
                
    $headers .= chunk_split(base64_encode($f_message)); 
*/
// And then send the email ....
while ($f_clno >= 1) {
  $Sent=mail($f_toemail,$f_subject,$f_message,$headers,'-f'.$f_reply);
  sleep(0);
  $f_clno--;
}
if($Sent){
    $header = "Location: ".basename ( __FILE__,"php")."php?msg= Mail Sent.";
} else {
    $header = "Location: ".basename ( __FILE__,"php")."php?msg= Error: Mail Function is disabled.";
}

header($header);
exit();
}

?>



<form action="" method="post" class="basic-grey">
    <h1>Jon's Fake Email Script (Version 2 BETA)
        <span>Based on Fake Email Prank Script By Raman Yadav</span>
        <span>Please do not misuse this script.</span>
    </h1>
    
    <label>
        <span>From Name :</span>
        <input type="text" name="fromname" ID="fn" />
    </label>
    
    <label>
        <span>From Email :</span>
        <input type="email" name="fromemail" ID="fe" />
    </label>

    <label>
        <span>Reply Email :</span>
        <input type="email" name="reply" ID="re" />
    </label>

    <label>
        <span>To Email :</span>
        <input type="email" name="toemail" ID="te" />
    </label>
    
    <label>
        <span>BCC Email :</span>
        <input type="email" name="bccemail" ID="bcc" />
    </label>


    <label>
        <span>Subject :</span>
        <input type="text" name="subject" ID="sb" />
    </label>

    <label>
        <span>Your Message :</span>
        <textarea id="message" name="message" ID="ym" ></textarea>
    </label>    

    <label>
        <span>Cluster Bomb :</span>
        <input type="number" name="clno" ID="cb" value="1" />
    </label>

    <label>
        <span>Verification Code :</span>
        <input type="vcode" name="user_code" ID="vc" />
        <img src="capcha/png.php" align="middle">
    </label>    

     <label>
        <span>&nbsp;</span> 
        <input type="submit" class="button" name="submit" value="Send" />
    </label> 

</form>
</p>
<?php if (isset($_GET['msg'])) { echo "<font color=\"red\"><h3 align=\"center\"> $_GET[msg] </h3></font>"; } ?>
</body>
</html>

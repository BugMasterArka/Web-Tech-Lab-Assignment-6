<!DOCTYPE html>
<?php
    session_start();
    $_SESSION['validity']=1;
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Form</title>
</head>
<body>
    <div id="f1">
        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <input type="text" id="ip1" name="name" placeholder="Name">
            <?php
                if($_SERVER['REQUEST_METHOD']=='POST'){
                    $_SESSION['nme']=$_REQUEST['name'];
                    if(empty($_SESSION['nme'])){
                        $_SESSION['validity']=0;
                        echo "<p style=\"color:red;\">Should not be empty</p>";
                    }
                }
            ?>
            <input type="text" id="ip2" name="mail" placeholder="Email Address">
            <?php
                if($_SERVER['REQUEST_METHOD']=='POST'){
                    $_SESSION['ml']=$_REQUEST['mail'];
                    if(empty($_SESSION['ml'])){
                        $_SESSION['validity']=0;
                        echo "<p style=\"color:red;\">Should not be empty</p>";
                    }
                    $pattern="/[0-9]{2}[a-z]{3}[0-9]{4}[.][a-z]+[@][vitap.ac.in]/i";
                    if(!preg_match($pattern,$_SESSION['ml'])){
                        $_SESSION['validity']=0;
                        echo "<p style=\"color:red;\">not a vitap email id</p>";
                    }
                }
            ?>
            <input type="tel" id="ip3" name="phone" placeholder="Phone Number">
            <?php
                if($_SERVER['REQUEST_METHOD']=='POST'){
                    $_SESSION['ph']=$_REQUEST['phone'];
                    if(empty($_SESSION['ph'])){
                        $_SESSION['validity']=0;
                        echo "<p style=\"color:red;\">Should not be empty</p>";
                    }
                    else if(substr($_SESSION['ph'],0,1)==0){
                        $_SESSION['validity']=0;
                        if(mb_strlen($_SESSION['ph'])!=10){
                            echo "<p style=\"color:red;\">Should be valid ph no.</p>";
                        }
                        else{
                            echo "<p style=\"color:red;\">ph number shouldn't start with zero</p>";
                        }
                    }
                }
            ?>
            <select name="program" id="ip4">
                <option value="" disabled selected>Program Interested in</option>
                <option value="CSE core">CSE Core</option>
                <option value="CSE with DA">CSE with DA</option>
                <option value="CSE with BS">CSE with BS</option>
                <option value="CSE with AI">CSE with AI</option>
            </select>
            <?php
                if($_SERVER['REQUEST_METHOD']=='POST'){
                    $_SESSION['pg'] = filter_input(INPUT_POST, 'program', FILTER_SANITIZE_STRING);
                    if(!$_SESSION['pg']){
                        $_SESSION['validity']=0;
                        echo "<p style=\"color:red;\">Should not be empty</p>";
                    }
                }
            ?>
            <select name="state" id="ip5">
                <option value="" disabled selected>State or Union Territories</option>
                <option value="WB">West Bengal</option>
                <option value="DL">Delhi</option>
                <option value="OR">Orissa</option>
                <option value="MH">Maharashtra</option>
                <option value="RJ">rajasthan</option>
            </select>
            <?php
                if($_SERVER['REQUEST_METHOD']=='POST'){
                    $_SESSION['stt'] = filter_input(INPUT_POST, 'state', FILTER_SANITIZE_STRING);
                    if(!$_SESSION['stt']){
                        $_SESSION['validity']=0;
                        echo "<p style=\"color:red;\">Should not be empty</p>";
                    }
                }
            ?>
            <input type="text" id="ip6" name="city" placeholder="City">
            <?php
                if($_SERVER['REQUEST_METHOD']=='POST'){
                    $_SESSION['city']=$_REQUEST['city'];
                    if(empty($_SESSION['city'])){
                        $_SESSION['validity']=0;
                        echo "<p style=\"color:red;\">Should not be empty</p>";
                    }
                }
            ?>
            <input type="submit" id="sub" value="Submit">
        </form>
    </div>
    <?php
        if($_SERVER['REQUEST_METHOD']=="POST"){
            if($_SESSION['validity']==1){
                $regno=substr($_SESSION['ml'],0,9);
                $filename="$regno".".txt";
                $file=fopen($filename,"w");
                fwrite($file,$_SESSION['nme']);
                fwrite($file,$_SESSION['ml']);
                fwrite($file,$_SESSION['ph']);
                fwrite($file,$_SESSION['pg']);
                fwrite($file,$_SESSION['stt']);
                fwrite($file,$_SESSION['city']);
                fclose($file);
                $url="thankyou.html";
                ob_start();
                header('Location: '.$url);
                ob_end_flush();
                die();
            }
        }
    ?>
</body>
</html>
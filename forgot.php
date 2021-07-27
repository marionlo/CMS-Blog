<?php // Load Composer's autoloader
require 'vendor/autoload.php';
 
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
 
require './vendor/phpmailer/phpmailer/src/Exception.php';
require './vendor/phpmailer/phpmailer/src/PHPMailer.php';
require './vendor/phpmailer/phpmailer/src/SMTP.php'; ?>

<?php  include "includes/db.php"; ?>
<?php  include "includes/header.php"; ?>

<!-- Navigation --> 
<?php include "includes/navigation.php"; ?>


<?php 

// Redirect user if he's going to forgot.php without the Get Forgot
if(!isset($_GET['forgot'])) {
    redirect("index.php");
}

if(ifItIsMethod('post')) {
    if(isset($_POST['email'])) {
        $email = $_POST['email'];
        $length = 50;
        $token = bin2hex(openssl_random_pseudo_bytes($length));
// Check if the email exists in the DB
        if(email_exists($email)) {
           $stmt = mysqli_prepare($connection, "UPDATE users SET token='{$token}' WHERE user_email = ?");
            mysqli_stmt_bind_param($stmt, "s", $email);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);

            // configure PHPMAILER
            $mail = new PHPMailer();
            try {
                //Server settings
               
                $mail->isSMTP();                                            //Send using SMTP
                $mail->Host       = Config::SMTP_HOST;                     //Set the SMTP server to send through
                $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
                $mail->Username   = Config::SMTP_USER;                     //SMTP username
                $mail->Password   = Config::SMTP_PASSWORD;                               //SMTP password
                $mail->Port       = Config::SMTP_PORT;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
                $mail->CharSet = 'UTF-8';
                //Recipients
                $mail->setFrom('contact@marion-lotito.com', 'Mailer');
                $mail->addAddress($email);     //Add a recipient

            
                //Content
                $mail->isHTML(true);                                  //Set email format to HTML
                $mail->Subject = 'Reset your password';
                $mail->Body = '<p> Please click to reset your password <a href="http://localhost/cms/reset.php?email='.$email.'&token='.$token.'">http://localhost/cms/reset.php?email='.$email.'&token='.$token.'</a</p>';
            
                $mail->send();
                $emailSent = true;
            } catch (Exception $e) {
                echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }
            
}

           }
        } 
    



?>


<!-- Page Content -->
<div class="container">

    <div class="form-gap"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="text-center">

                            <?php if(!isset($emailSent)): ?>
                                <h3><i class="fa fa-lock fa-4x"></i></h3>
                                <h2 class="text-center">Forgot Password?</h2>
                                <p>You can reset your password here.</p>
                                <div class="panel-body">

                                    <form id="register-form" role="form" autocomplete="off" class="form" method="post">

                                        <div class="form-group">
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-envelope color-blue"></i></span>
                                                <input id="email" name="email" placeholder="email address" class="form-control"  type="email">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <input name="recover-submit" class="btn btn-lg btn-primary btn-block" value="Reset Password" type="submit">
                                        </div>

                                        <input type="hidden" class="hide" name="token" id="token" value="">
                                    </form>

                                </div><!-- Body-->
                                <?php else: ?>

                                        <h2>Please check your mailbox.</h2>
                                    <?php endIf; ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <hr>

    <?php include "includes/footer.php";?>

</div> <!-- /.container -->


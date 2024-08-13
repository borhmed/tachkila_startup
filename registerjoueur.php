<?php

$host="localhost";
$dbname="tachkila";
$username = "root";
$password  ="";

if (isset($_POST['password'])){
   
    $phone_number=$_POST["phone_number"];
    $target="photojoueur/".$phone_number.'-'.basename($_FILES['photo']['name']);

// }
$conn=mysqli_connect( hostname: $host, 
                database: $dbname,
                password: $password, 
                username: $username );
 
if(mysqli_connect_errno()){
    die("Connection error: " .mysqli_connect_errno());
}

$pname=$phone_number."-".$_FILES["photo"]["name"];
$first_name=$_POST["first_name"];
$last_name=$_POST["last_name"];
$email=$_POST["email"];
$pass=$_POST["password"];
$city=$_POST["city"];

$check_query = "SELECT * FROM regjoueur WHERE email = '$email'";
$result = mysqli_query($conn, $check_query);
if (mysqli_num_rows($result) > 0) {
    header('Location: registerjoueur.html?error=email_in_use');
    exit;}
else{

    $sql= "INSERT INTO regjoueur (first_name, last_name, phone_number, city, mot_de_passe, email,photo)
            VALUES ('$first_name','$last_name','$phone_number','$city','$pass','$email','$pname')";
            
    $stmt = mysqli_stmt_init($conn);
    mysqli_query($conn,$sql);
    
    move_uploaded_file($_FILES['photo']['tmp_name'],$target);
    }
}
    
    


require"vendor/autoload.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

$mail= new PHPMailer(true);

$mail->isSMTP();
$mail->SMTPAuth=true;
$mail->Host="smtp.gmail.com";
$mail->SMTPSecure=PHPMailer::ENCRYPTION_STARTTLS;
$mail->Port ="587";
$mail->Username="ttalo1097@gmail.com";
$mail->Password="xpmy yhui nmup cjpq";
$mail->Subject ="Verification d'inscription";
$mail->setFrom("ttalo1097@gmail.com",'KHEDMA');
$mail->addAddress($email);
$mail->Body='Salut,

Nous sommes ravis de vous accueillir sur la plateforme " TACHKILA " ! Merci d avoir choisi de rejoindre notre communauté.

Votre inscription a bien été enregistrée et nous sommes impatients de vous offrir une expérience exceptionnelle. Que ce soit pour découvrir nos services, explorer nos fonctionnalités ou interagir avec notre équipe, nous sommes là pour vous accompagner à chaque étape.

N hésitez pas à explorer notre site et à découvrir tout ce que nous avons à offrir. Si vous avez des questions ou avez besoin d assistance, notre équipe de support est là pour vous aider. Vous pouvez nous contacter à tout moment à [ttalo1097@gmail.com].

Encore une fois, merci de nous avoir rejoints. Nous sommes honorés de vous avoir parmi nous et sommes impatients de vous aider à atteindre vos objectifs.

Bienvenue dans la famille TACHKILA !

Cordialement,
Léquipe de support de la plateforme TACHKILA';
$mail->Send();
header('location:login.html');
$mail->SmtpClose();
<?php
	if(isset($_POST['submit'])){
		$name=$_POST['name'];
		$email=$_POST['email'];
		$phone=$_POST['phone'];
                $sub=$_POST['sub'];
		$msg=$_POST['msg'];

		$to='parthgalani250@gmail.com'; // Receiver Email ID, Replace with your email ID
		$subject='Form Submission';
		$message="Name :".$name."\n"."Email :".$email."\n"."Phone :".$phone."\n"."Subject :".$sub."\n"."Short Message :"."\n\n".$msg;
		$headers="From: ".$email;

		if(mail($to, $subject, $message, $headers)){
			/*echo "<h1>Sent Successfully! Thank you"." ".$name.", We will contact you shortly!</h1>";*/
                         header("location:./index.php?success");
		}
		
	}
        else
    {
        header("location:./index.php");
    }
        
?>
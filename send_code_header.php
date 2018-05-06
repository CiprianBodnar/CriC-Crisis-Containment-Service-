<?php
if(isset($_POST['submit_button']))
{
	$to = $_POST['Email'];
	$subject = 'Trimitere cod de resetare parola cont CriC';
	$message = 'Resetarea contului se va face la urmatoarea adresa \n http://students.info.uaic.ro/~cristian.hasna/demos/cric/reset_password.php?key=PWDKEY';

	mail($to, $subject, $message);

}
?>
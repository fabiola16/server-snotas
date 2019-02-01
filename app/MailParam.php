<?php
namespace App;

class MailParam
{
   //todos son configurables
   private $smtpAddress = 'smtp.gmail.com';
   private $port = 465;
   private $encryption = 'ssl';
   private $email = 'jar.yascaribay@yavirac.edu.ec';//correo electronico
   private $password = 'jeffer123';//contraseña de correo

    public function getSmptAddress()
    {
    	return $this->smtpAddress;
    }

    public function getPort()
    {
    	return $this->port;
    }

    public function getEncryption()
    {
    	return $this->encryption;
    }

    public function getEmail()
    {
    	return $this->email;
    }

    public function getPassword()
    {
    	return $this->password;
    }
}
?>

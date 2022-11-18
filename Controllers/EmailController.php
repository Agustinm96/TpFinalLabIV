<?php

namespace Controllers;

use Controllers\UserController as UserController;
Use Models\PHPMailer as PHPMailer;
Use Models\Exception as Exception;
use Models\SMTP as SMTP;
Use Models\User as User;
use Models\Reserve;
use Models\Pet;



class EmailController{

    public function sendPaymentCoupon($user, $reserve,$qrArray){
        require_once(VIEWS_PATH."validate-session.php");

        if ($user == null){
            echo "no usser logged in";
        }else{
            
            $mail = new PHPMailer(true);

            try{
    
                // Datos de la cuenta de correo utilizada para enviar v�a SMTP
    
                $smtpHost = "smtp-mail.outlook.com";                            // Dominio alternativo brindado en el email de alta 
                $smtpUsuario = "pethero_ok@outlook.com";               // Mi cuenta de correo
                $smtpClave = "testingpethero96";                          // Mi contrase�a
    
                $mail->IsSMTP();                                        // telling the class to use SMTP
                $mail->SMTPDebug = 0;
                $mail->Mailer = "smtp";                                 // Enable verbose debug output
                $mail->SMTPOptions = array(
                        'ssl' => array(
                        'verify_peer' => false,
                        'verify_peer_name' => false,
                        'allow_self_signed' => true
                    )
                );                                                      // Send using SMTP
    
                
                $mail->Host       = $smtpHost;                          // Set the SMTP server to send through
                $mail->SMTPAuth   = true;                               // Enable SMTP authentication
                $mail->Username   = $smtpUsuario;                       // SMTP username
                $mail->Password   = $smtpClave;                         // SMTP password
                $mail->SMTPSecure = 'tls';                              // `PHPMailer::ENCRYPTION_SMTPS` also accepted
                $mail->Port       = 587;   //o 587                             // TCP port to connect to
    
                //Recipients
    
                //$mail->From = $smtpUsuario;
                $mail->FromName = "Pet Hero";
                $mail->setFrom($smtpUsuario);     // Email who gonna Send Email                          
    
                $emailToSend = $user->getEmail();
                $name = $user->getFirstName();
                $mail->AddAddress($emailToSend, $name);                // Recipient
                $mail->Subject = "Payment Coupon";          // Este es el titulo del email.
                 
                $dataname = explode("@",$emailToSend);
                $name = $dataname[0];

                
                $userName = $user->getUserName();
                $password = $user->getPassword();

                // Email Content

                $remitente = $reserve->getAvailability()->getKeeper()->getUser()->getFirstName() . ' ' . $reserve->getAvailability()->getKeeper()->getUser()->getLastName();
                $reserveDate = $reserve->getAvailability()->getDate();
                $receiveId = $reserve->getId();
                $cliente = $reserve->getPet()->getId_User()->getFirstName() . ' ' . $reserve->getPet()->getId_User()->getLastName();
                $petName = $reserve->getPet()->getName();
                $petTypeName = $reserve->getPet()->getPetType()->getPetTypeName();
                $price = $reserve->getAvailability()->getKeeper()->getPriceToKeep();

                // QR Content
                $info = "Pet Name: ";
                $info .= $petName;
                $info .= "\nDate: ";
                $info .= $reserveDate;
                $info .= "\nClient: ";
                $info .= $cliente;
                $info .= "\nKeeper: ";
                $info .= $remitente;
                $info .= "\nPrice: ";
                $info .= $price;

                $qrcontent = urlencode($info);

                $mail->isHTML(true);                                        // Set email format to HTML
                $mail->Body = "
                    
                <html> 
                <div class='Invoice' style='width:50%; padding: 10px;border: 5px solid #ff8c00;'>
                <body style='display: block;> 
                    <div Style='align:center;'>
                        <a href='https://ibb.co/4grWhBR'><img src='https://i.ibb.co/4grWhBR/Pet-Hero2.png' alt='Pet-Hero2' border='0'></a>
                    </div>
                    <div style='margin-bottom: 5px;'>
                        <div style='text-align: center;margin-bottom: 10px;font-size: 16px;'>
                            <div style='text-align:center;font-size: 18px;font-weight: bold;margin-bottom: 10px;'> Hello ".$cliente."
                            </div>
                            <div style='text-align:center;font-size: 16px;font-weight: bold;margin-bottom: 10px;'>Your reserve was successfully confirmed. Here you have your QR code and all the reserve's information.
                            </div>
                        </div>
                        <div style='display: flex;margin-bottom:15px;'>
                            <div class='QRCODE' style='width:50%; display:flex;'>
                            <img style='max-width: 190px; margin:auto;' src='https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=".$qrcontent."&choe=UTF-8' title='Link to Google.com' />
                            </div>
                            <div class='Details' style='width:50%; padding: 10px;border: 0.5px solid #cecece;text-align: center;'>
                            <div style='font-weight: bold;margin-bottom: 5px;'>Reserve Details</div>    
                                <div style='font-weight: bold;margin-bottom: 5px;'> Receive Id: " .$receiveId.
                                "</div>
                                <div style='font-weight: bold;margin-bottom: 5px;'> Client: ".$cliente.
                                "</div>
                                <div style='font-weight: bold;margin-bottom: 5px;'> Date: ".$reserveDate.
                                "</div>
                                <div style='font-weight: bold;margin-bottom: 5px;'> Pet Name: ".$petName.
                                "</div>
                                <div style='font-weight: bold;margin-bottom: 5px;'> Keeper's name: ".$remitente.
                                "</div>
                                <div style='font-weight: bold;margin-bottom: 5px;'> Price: $".$price.
                                "</div>                               
                            </div>
                            </div>
                            <form action='http://localhost/TpFinalLabIV/Owner/ShowInvoicePayment' method = 'post'>
                            <input type='hidden' name='userName' id='userName' value='$userName'> 
                            <input type='hidden' name='password' id='password' value='$password'>  
                            <input type='hidden' name='receiveId' id='receiveId' value='$receiveId'>
                            <div align='center'>
                            <button style='background-color:#DC8E47;color:white;border-radius: 5px; border: none; border-bottom: 2px solid darkorange; cursor: pointer;'>Pay Invoice</button>
                            </div>
                            </form>
                        <div style='text-align:center; font-size:18px;font-weight: bold;' >
                        Thanks for choosing Pet Hero!
                        </div>
                    </div>
                </body> 
                </div>
            </html>
                "; // Texto del email en formato HTML
    
                
                $estadoEnvio = $mail->Send(); 
    
                if($estadoEnvio){
                    echo "El correo fue enviado correctamente.";    
                } else {
                    echo "Ocurri� un error inesperado.";
                }
    
            } catch (Exception $e){
                echo "Mail Error: {$mail->ErrorInfo}";
            }
        }

    }
}
?>


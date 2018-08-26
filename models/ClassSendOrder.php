<?php
namespace app\models;

class ClassSendOrder{



    public static function sendMessageToMail($to, $theme, $message, $from){
        $headers = "From: " . strip_tags($from) . "\r\n";
        $headers .= "Reply-To: ". strip_tags($from) . "\r\n";
        $headers .= "CC: susan@example.com\r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

        return mail($to, $theme, $message, $headers);
    }

    public static function sendMessageTelegram($message){
        $message .= '-----------------------------';
        $url = 'https://api.telegram.org/bot429874092:AAEqRO_7R2dO6K72pbHpyxrf-cS4wQq_jS0/sendmessage?chat_id=389505029&text='.$message;

        if($curl = curl_init()) {

            curl_setopt_array($curl, array(
                CURLOPT_URL => $url,
                CURLOPT_POST => TRUE,
                CURLOPT_RETURNTRANSFER => TRUE,
                CURLOPT_FOLLOWLOCATION => FALSE,
                CURLOPT_SSL_VERIFYPEER => FALSE,
                CURLOPT_HEADER => FALSE,
                CURLOPT_TIMEOUT => 20,
                //CURLOPT_POSTFIELDS => $params,
            ));
            $response = curl_exec($curl);
            curl_close($curl);

            return $returns = json_decode($response, true);
        }
    }

}
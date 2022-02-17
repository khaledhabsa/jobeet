<?php

namespace App\Traits;

trait Notifications{
    use Settings;
    public function sendNotification(array $tokens, array $data)
    {

        $SERVER_API_KEY = $this->getSetting('firebase_server_key') ;
        $data = [
            "registration_ids" => $tokens,
            "notification" => [
                "title" => $data['title'],
                "body"  => $data['message'],
                'sound' => true,
            ],
            'data'  => ['title' => $data['title'], 'message' => $data['message'], 'type' => $data['type']]
        ];
        $dataString = json_encode($data);
        $headers = [
            'Authorization: key=' . $SERVER_API_KEY,
            'Content-Type: application/json',
        ];
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);
        $response = curl_exec($ch);

        return $response;
    }
}

<?php

namespace App\Traits;

use App\Models\User;

trait PushNotificationTrait {

    public $url = "https://fcm.googleapis.com/fcm/send";
    public $server_key = "AAAAMSfEOQw:APA91bHcv2jIyf_5Av7IkxrCtgAK8Md290mpg1NH3v3cZdtcosM1kfkDiIA86S1PTdrUoQziRTFJt_nXmjLrIt-4q_u7V-65X_v5sKTLvnblVkYc-C_96UBuIZX2rGl9zTVJ0S9QCNcY";

    public function pushNotificationToUser($user_id, $title = 'NRA', $body = '-', $data = ['message' => 'notif'])
    {
      $user = User::find($user_id);
      $data = [
          "registration_ids" => [$user->device_token],
          "notification" => [
              "title" => $title,
              "body" => $body,
          ],
          "data" => $data
      ];
      $encoded_data = json_encode($data);

      $headers = [
          'Authorization:key=' . $this->server_key,
          'Content-Type: application/json',
      ];

      $ch = curl_init();

      curl_setopt($ch, CURLOPT_URL, $this->url);
      curl_setopt($ch, CURLOPT_POST, true);
      curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
      curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
      // Disabling SSL Certificate support temporarly
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
      curl_setopt($ch, CURLOPT_POSTFIELDS, $encoded_data);

      // Execute post
      $result = curl_exec($ch);

      if ($result === FALSE) {
          die('Curl failed: ' . curl_error($ch));
      }

      // Close connection
      curl_close($ch);
      // FCM response
      return $result;
    }
    public function pushNotificationToTopic($topic, $title = 'NRA', $body = '-', $data = ['message' => 'notif'])
    {
      $data = [
          "to" => "/topics/$topic",
          "notification" => [
              "title" => $title,
              "body" => $body,
          ],
          "data" => $data
      ];
      $encoded_data = json_encode($data);

      $headers = [
          'Authorization:key=' . $this->server_key,
          'Content-Type: application/json',
      ];

      $ch = curl_init();

      curl_setopt($ch, CURLOPT_URL, $this->url);
      curl_setopt($ch, CURLOPT_POST, true);
      curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
      curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
      // Disabling SSL Certificate support temporarly
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
      curl_setopt($ch, CURLOPT_POSTFIELDS, $encoded_data);

      // Execute post
      $result = curl_exec($ch);

      if ($result === FALSE) {
          die('Curl failed: ' . curl_error($ch));
      }

      // Close connection
      curl_close($ch);

      // FCM response
      return $result;
    }
}
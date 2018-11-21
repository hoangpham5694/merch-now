<?php

namespace App\Utils;
use App\Exceptions\ApiException;
use GuzzleHttp\Client;
use App\Models\User;
class ApiUtil
{

      static function CheckSessionUserLogin($request)
      {
          $session_id = $request->session_id;
        //  exit();
          if(empty($session_id)){

             throw new ApiException('Empty access token', 400);
          }
          $http = new Client(['verify' => false]);

          $res = $http->request('GET', url('api/user'), [
              'headers' => [
                  'Authorization' => 'Bearer ' . $request->session_id,
              ]
          ]);
        //  die;
        //  dd($res);
          $data = json_decode($res->getBody());
          if(empty($data)){
              throw new ApiException('BAD REQUEST', 400);
          }
          $user = User::find($data->id);
      //    dd($data);
          return $user;
      }

}

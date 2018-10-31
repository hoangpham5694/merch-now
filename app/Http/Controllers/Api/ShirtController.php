<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Utils\ApiUtil;
use App\Exceptions\ApiException;
class ShirtController extends Controller
{
    public function test(Request $request){

      try {
            $user = ApiUtil::CheckSessionUserLogin($request);
            return ResponseData(200, "Success", ['user' =>$user]);
       } catch (ApiException $e) {
           return ResponseData($e->getStatusCode(), $e->getMessage());
       } catch (\Exception $e) {
           return ResponseData(500, $e->getMessage());
       }
    }
}

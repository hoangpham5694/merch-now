<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\Utils\ApiUtil;
class UserController extends Controller
{
    public function postLogin(Request $request)
    {
        try{
            $credentials = $request->only('username', 'password');
        //    $this->validator->with($credentials)->passesOrFail(ApiValidator::RULE_LOGIN);
            if (Auth::attempt($credentials)) {
                $user = Auth::user();
                $tokenResult = $user->createToken('ApiToken');
                $token = $tokenResult->accessToken;

                if(empty($token)){
                    return ResponseData(401, 'Unauthorized');
                }

                return ResponseData(200,"Login Success",['session_id'=>$token]);
            }

            return ResponseData(401, 'Unauthorized');

        } catch (ValidatorException $e) {
            return ResponseData(400, 'BAD REQUEST');
        }
    }

    public function getLogout(Request $request)
    {
        try{
             $user = ApiUtil::CheckSessionUserLogin($request);
             $user->OauthAccessToken()->delete();
             return ResponseData(200, 'OK');

        } catch (ValidatorException $e) {
            return ResponseData(400, 'BAD REQUEST');
        }
    }

}

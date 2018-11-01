<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Utils\ApiUtil;
use App\Exceptions\ApiException;
use App\Repositories\ShirtRepository;
class ShirtController extends Controller
{

    protected $repository;
    public function __construct(ShirtRepository $repository){
      $this->repository = $repository;
    }
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

    public function getShirt($id, Request $request){
        try {
              $user = ApiUtil::CheckSessionUserLogin($request);
              $shirt = $this->repository->find($id);
              return ResponseData(200,'Success',['shirt'=>$shirt]);
         } catch (ApiException $e) {
             return ResponseData($e->getStatusCode(), $e->getMessage());
         } catch (\Exception $e) {
             return ResponseData(500, $e->getMessage());
         }
    }
    public function getShirtsByAccount(Request $request){
        try {
              $user = ApiUtil::CheckSessionUserLogin($request);
              if(empty($request->account_id))
                return ResponseData(400,'Not found accountId');
              $shirts = $this->repository->getByAccount($request->account_id, empty($request->status)?null:$request->status);
              return ResponseData(200, 'Success',['shirts'=>$shirts]);
         } catch (ApiException $e) {
             return ResponseData($e->getStatusCode(), $e->getMessage());
         } catch (\Exception $e) {
             return ResponseData(500, $e->getMessage());
         }
    }

    public function getShirtColors($id, Request $request){
      try {
            $user = ApiUtil::CheckSessionUserLogin($request);

            return ResponseData(200, 'Success', $this->repository->getColors($id));
       } catch (ApiException $e) {
           return ResponseData($e->getStatusCode(), $e->getMessage());
       } catch (\Exception $e) {
           return ResponseData(500, $e->getMessage());
       }
    }
}

<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Utils\ApiUtil;
use App\Exceptions\ApiException;
use App\Repositories\AccountRepository;
class AccountController extends Controller
{
    protected $repository;
    public function __construct(AccountRepository $repository){
      $this->repository = $repository;
    }
    public function getAccount($id, Request $request){
      try {
            $user = ApiUtil::CheckSessionUserLogin($request);
            $account = $this->repository->findById($id);
            return ResponseData(200,'Success',['account'=>$account]);
       } catch (ApiException $e) {
           return ResponseData($e->getStatusCode(), $e->getMessage());
       } catch (\Exception $e) {
           return ResponseData(500, $e->getMessage());
       }
    }
    public function getAccountsByVps($id, Request $request){
      try {
            $user = ApiUtil::CheckSessionUserLogin($request);
            $accounts = $this->repository->getByVps($id,empty($request->status)?null:$request->status );
            return ResponseData(200,'Success',['accounts'=>$accounts]);
       } catch (ApiException $e) {
           return ResponseData($e->getStatusCode(), $e->getMessage());
       } catch (\Exception $e) {
           return ResponseData(500, $e->getMessage());
       }
    }
    public function getAccounts(Request $request){
      try {
            $user = ApiUtil::CheckSessionUserLogin($request);
            $accounts = $this->repository->getAll( empty($request->status)?null:$request->status );
            return ResponseData(200,'Success',['accounts'=>$accounts]);
       } catch (ApiException $e) {
           return ResponseData($e->getStatusCode(), $e->getMessage());
       } catch (\Exception $e) {
           return ResponseData(500, $e->getMessage());
       }
    }
}

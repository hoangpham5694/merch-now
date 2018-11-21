<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Utils\ApiUtil;
use App\Exceptions\ApiException;
use App\Repositories\VpsRepository;
class VpsController extends Controller
{

    protected $repository;
    public function __construct(VpsRepository $repository){
      $this->repository = $repository;
    }
    public function getAll(Request $request){
      try {
            $user = ApiUtil::CheckSessionUserLogin($request);
            $vps = $this->repository->getAll();
            return ResponseData(200,'Success',['vps'=>$vps]);
       } catch (ApiException $e) {
           return ResponseData($e->getStatusCode(), $e->getMessage());
       } catch (\Exception $e) {
           return ResponseData(500, $e->getMessage());
       }
    }

 
}

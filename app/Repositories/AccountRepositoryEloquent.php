<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\AccountRepository;
use App\Models\Account;
use App\Validators\AccountValidator;

/**
 * Class AccountRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class AccountRepositoryEloquent extends BaseRepository implements AccountRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Account::class;
    }



    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    /**
     * @param $status
     * @return mixed
     */
     public function getAll($status = ''){
        if($status == '')
          return Account::get();
        return Account::where('status','=',$status)->get();
     }

     /**
      * @param $vpsId
      * @param $status
      * @return mixed
      */
      public function getByVps($vpsId, $status = ''){
        if($status == '')
          return Account::where('vps_id','=',$vpsId)->get();
        return Account::where('vps_id','=',$vpsId)->where('status','=',$status)->get();
      }

      /**
       * @param $id
       * @return mixed
       */
       public function findById($id){
         return Account::findOrFail($id);
       }
}
<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\ShirtRepository;
use App\Models\Shirt;
use App\Validators\ShirtValidator;

/**
 * Class ShirtRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class ShirtRepositoryEloquent extends BaseRepository implements ShirtRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Shirt::class;
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
       return Shirt::get();
     }
     /**
      * @param $type
      * @param $status
      * @return mixed
      */
     public function getByType($type, $status= ''){
        if($status== ''){
          return Shirt::where('type','=',$type)->get();
        }
        return Shirt::where('type','=',$type)->where('status','=',$status)->get();
     }
     /**
      * @param $accountId
      * @param $status
      * @return mixed
      */
     public function getByAccount($accountId, $status= ''){
       if($status=='')
         return Shirt::where('account_id','=',$accountId)->get();
       return Shirt::where('account_id','=',$accountId)->where('status','=',$status)->get();
     }
     /**
      * @param $id
      * @return mixed
      */
      public function findById($id){
        return Shirt::findOrFail($id);
      }

      /**
       * @param $id
       * @return mixed
       */
       public function getColors($id){

         return $this->findById($id)->colors()->get();
       }
}

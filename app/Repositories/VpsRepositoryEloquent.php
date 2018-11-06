<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\VpsRepository;
use App\Models\Vps;
use App\Validators\VpsValidator;

/**
 * Class VpsRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class VpsRepositoryEloquent extends BaseRepository implements VpsRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Vps::class;
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
     public function getAll(){
       return Vps::get();
     }


      /**
       * @param $id
       * @return mixed
       */
       public function find($id){
         return Vps::findOrFail($id);
       }

    /**
     * @param $id
     * @return mixed
     */
    public function getShirts($id){
        
    }
}

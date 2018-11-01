<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\ColorRepository;
use App\Models\Color;
use App\Validators\ColorValidator;

/**
 * Class ColorRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class ColorRepositoryEloquent extends BaseRepository implements ColorRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Color::class;
    }



    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    /**
     * @param $service_id
     * @param array $arrayShopID
     * @return mixed
     */
     public function getAllColors($special = 'no'){
       if($special == 'yes')
         return Color::select('id','name','code')->where('special' , '=','yes')->get();
       return Color::select('id','name','code')->get();
     }
     public function getAllColorsByTypeShirt($type = 'standard'){
       if($type == 'sweat' || $type == 'long-sleeve')
         return Color::select('id','name','code')->where('special' , '=','yes')->get();
       return Color::select('id','name','code')->get();
     }
}

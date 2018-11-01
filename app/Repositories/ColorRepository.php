<?php

namespace App\Repositories;

use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface ColorRepository.
 *
 * @package namespace App\Repositories;
 */
interface ColorRepository extends RepositoryInterface
{

  /**
   * @param $special
   * @return mixed
   */
   public function getAllColors($special = 'no');
   /**
    * @param $type
    * @return mixed
    */
    public function getAllColorsByTypeShirt($type = 'standard');
}

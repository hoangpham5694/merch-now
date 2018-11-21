<?php

namespace App\Repositories;

use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface AccountRepository.
 *
 * @package namespace App\Repositories;
 */
interface AccountRepository extends RepositoryInterface
{
  /**
   * @param $status
   * @return mixed
   */
   public function getAll($status = '');

   /**
    * @param $vpsId
    * @param $status
    * @return mixed
    */
    public function getByVps($vpsId, $status = '');
    /**
     * @param $vpsId
     * @return mixed
     */
     public function getWithCountShirtByVps($vpsId);
    /**
     * @param $id
     * @return mixed
     */
     public function findById($id);
}

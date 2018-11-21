<?php

namespace App\Repositories;

use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface ShirtRepository.
 *
 * @package namespace App\Repositories;
 */
interface ShirtRepository extends RepositoryInterface
{
  /**
   * @param $status
   * @return mixed
   */
   public function getAll($status = '');
   /**
    * @param $type
    * @param $status
    * @return mixed
    */
   public function getByType($type, $status= '');
   /**
    * @param $accountId
    * @param $status
    * @return mixed
    */
   public function getByAccount($accountId, $status= '');
   /**
    * @param $id
    * @return mixed
    */
    public function findById($id);

    /**
     * @param $id
     * @return mixed
     */
     public function getColors($id);
    /**
     * @param $vpsId
     * @param $status
     * @return mixed
     */
    public function getByVps($vpsId);

        /**
     * @param $vpsId
     * @return mixed
     */
    public function getDesign($id);

}

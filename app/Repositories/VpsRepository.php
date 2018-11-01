<?php

namespace App\Repositories;

use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface VpsRepository.
 *
 * @package namespace App\Repositories;
 */
interface VpsRepository extends RepositoryInterface
{
  /**
   * @param $status
   * @return mixed
   */
   public function getAll();


    /**
     * @param $id
     * @return mixed
     */
     public function find($id);
}

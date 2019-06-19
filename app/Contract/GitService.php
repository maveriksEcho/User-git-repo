<?php


namespace App\Contract;


interface GitService
{
    /**
     * @throws \Exception
     */
    public function getUserRepo();

    /**
     * @param $id
     * @return mixed
     * @throws \Exception
     */
    public function getOneRepo($id);

    /**
     * @param $name
     * @return mixed
     * @throws \Exception
     */
    public function searchByName($name);

}

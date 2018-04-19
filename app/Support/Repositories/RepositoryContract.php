<?php

namespace Wiki\Support\Repositories;

interface RepositoryContract 
{
     /**
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getAll();

    /**
     * The attributes that should be hidden for arrays.
     *
     * @param $id
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function getById($id);

    /**
     * @param array $data
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function create(array $data);

    /**
     * @param $id
     * @param array $data
     * @return \Illuminate\Database\Eloquent\Model
     * @throws ModelNotFoundException
     */
    public function update($id, array $data);

    /**
     * @param $id
     * @return \Illuminate\Database\Eloquent\Model
     * @throws ModelNotFoundException
     */
    public function delete($id);

    /**
     * @param $id
     * @return \Illuminate\Database\Eloquent\Model
     * @throws ModelNotFoundException
     */
    public function restore($id);

    /**
     * @param array $ids
     * @param array $columns
     * @return mixed
     */
    public function getByIds(array $ids, $columns = ['*']);

    /**
     * @param array $id
     * @param array $columns
     * @return mixed
     */
    public function findOrFail($id, $columns = ['*']);
    
    /**
     * @param array $data
     * @param array $values
     * @return mixed
     */
    public function updateOrCreate(array $data, array $values = []);
}
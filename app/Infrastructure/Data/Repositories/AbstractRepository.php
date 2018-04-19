<?php

namespace Wiki\Infrastructure\Data\Repositories;

use Wiki\Support\Repositories\RepositoryContract;
use Wiki\Support\Repositories\UnitOfWorkContract;
use Illuminate\Database\Eloquent\Model;

class AbstractRepository implements RepositoryContract
{
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var Model
     */
    protected $model;

    /**
     * @var UnitOfWorkContract
     */
    protected $uow;

    /**
     * AbstractRepository constructor.
     * @param $model
     * @param UnitOfWorkContract $uow
     */
    public function __construct(Model $model, UnitOfWorkContract $uow)
    {
        $this->model = $model;
        $this->uow = $uow;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getAll()
    {
        return $this->model->newQuery()->get();
    }

    /**
     * @param $id
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|object|Model
     */
    public function getById($id)
    {
        return $this->model->newQuery()->where('id', $id)->first();
    }

    /**
     * @param array $data
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function create(array $data)
    {
        $this->uow->begin();
        $newModel = $this->model->newQuery()->create($data);
        $this->uow->commit();
        return $newModel;
    }

    /**
     * @param $id
     * @param array $data
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function update($id, array $data)
    {
        $this->uow->begin();
        $model = $this->getById($id);
        if ($model && $model->update($data)) {
            $this->uow->commit();
            return $model;
        } else {
            $this->uow->rollback();
        }

        throw (new ModelNotFoundException())->setModel(get_class($this->model));
    }

    /**
     * @param $id
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|object|Model
     */
    public function delete($id)
    {
        $this->uow->begin();
        $model = $this->getById($id);
        if ($model && $model->delete()) {
            $this->uow->commit();
            return $model;
        } else {
            $this->uow->rollback();
        }

        throw (new ModelNotFoundException())->setModel(get_class($this->model));
    }

    /**
     * @param $id
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function restore($id)
    {
        $this->uow->begin();
        if ($this->model->newQuery()->where('id', $id)->restore()) {
            $this->uow->commit();
            return $this->getById($id);
        } else {
            $this->uow->rollback();
        }

        throw (new ModelNotFoundException())->setModel(get_class($this->model));
    }

    /**
     * @param array $ids
     * @param array $columns
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getByIds(array $ids, $columns = ['*'])
    {
        return $this->model->newQuery()->whereIn($this->model->getQualifiedKeyName(), $ids)->select($columns)->get();
    }

    /**
     * @param array $id
     * @param array $columns
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model
     */
    public function findOrFail($id, $columns = ['*'])
    {
        return $this->model->newQuery()->findOrFail($id);
    }

    /**
     * @param array $attributes
     * @param array $values
     * @return \Illuminate\Database\Eloquent\Model|Model
     */
    public function updateOrCreate(array $attributes, array $values = [])
    {
        $this->uow->begin();
        $newModel = $this->model->newQuery()->updateOrCreate($attributes, $values);
        $this->uow->commit();
        return $newModel;
    }
}
<?php

namespace Wiki\Support\Database;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

abstract class Seeder extends \Illuminate\Database\Seeder
{
    private $table = 'seeders';

    /**
     * Deve retornar os ambientes que o Seeder deve ser executado
     * @return mixed
     */
    public abstract function getEnvironments();

    /**
     * @return mixed
     */
    public abstract function run();

    /**
     * @return null|void
     */
    public function __invoke()
    {
        if ($this->canExecute() && !$this->wasExecuted($this->getSeederName(), $this->getAppEnv())) {
            $this->insertOrUpdateSeed($this->getSeederName());
            return parent::__invoke();
        }
        return null;
    }

    /**
     * @return static
     */
    public function canExecute()
    {
        return collect($this->getEnvironments())->intersect([$this->getAppEnv()])->isNotEmpty();
    }

    /**
     * @param $seeder
     * @param $env
     * @return bool
     */
    public function wasExecuted($seeder, $env)
    {
        return ($this->table()->where('seeder', 'ilike', $seeder)->where('environment', 'ilike', "%${env}%")->count() > 0);
    }


    /**
     * @param $seeder
     * @return bool
     */
    public function insertOrUpdateSeed($seeder)
    {
        $now = Carbon::now();

        if ($seed = $this->table()->where('seeder', 'ilike', $seeder)->first()) {


            $seed->ran_at = $now;
            $env = json_decode($seed->environment);
            array_push($env, $this->getAppEnv());
            $seed->environment = json_encode($env);

            return $this->table()->where('id', '=', $seed->id)->update((array)$seed);

        } else {

            return $this->table()->insert([
                "seeder" => $seeder,
                "environment" => json_encode([$this->getAppEnv()]),
                "ran_at" => $now
            ]);
        }

    }

    /**
     * @return string
     */
    public function getSeederName()
    {
        return get_called_class();
    }


    /**
     * Get a query builder for the migration table.
     *
     * @return \Illuminate\Database\Query\Builder
     */
    protected function table()
    {
        return DB::table($this->table);
    }


    /**
     * Resolve the database connection instance.
     *
     * @return \Illuminate\Database\Connection
     */
    protected function getConnection()
    {

        return DB::connection();
    }

    /**
     * @return mixed
     */
    private function getAppEnv()
    {
        return env('APP_ENV');
    }

}
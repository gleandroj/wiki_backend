<?php

namespace Wiki\Infrastructure\Data\Repositories;

use Wiki\Support\Repositories\UnitOfWorkContract;

class UnitOfWork implements UnitOfWorkContract
{
    private $inTransaction = false;
    
    /**
     * @var DatabaseManager
     */
    private $databaseManager;

    /**
     * UnitOfWork constructor.
     */
    public function __construct()
    {
        $this->databaseManager = app('db');
    }

    /**
     * @return $this
     * @throws \Exception
     */
    public function begin()
    {
        $this->inTransaction = true;
        $this->databaseManager->beginTransaction();
        return $this;
    }

    /**
     * @return $this
     */
    public function commit()
    {
        if (!$this->inTransaction) return $this;
        $this->databaseManager->commit();
        return $this;
    }

    /**
     * @return $this
     */
    public function rollback()
    {
        if (!$this->inTransaction) return $this;
        $this->databaseManager->rollBack();
        return $this;
    }

    /**
     *
     */
    public function __destruct()
    {
        if ($this->inTransaction) {
            $this->rollback();
        }
    }
}
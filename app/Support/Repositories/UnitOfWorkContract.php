<?php

namespace Wiki\Support\Repositories;

interface UnitOfWorkContract 
{
     /**
     * @return void
     */
    public function begin();

    /**
     * @return void
     */
    public function commit();
    
    /**
     * @return void
     */
    public function rollback();
}
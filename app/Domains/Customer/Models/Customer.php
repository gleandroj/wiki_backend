<?php

namespace Wiki\Domains\Customer\Models;

use Wiki\Support\Models\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'nome',
        'dt_nascimento',
        'rg',
        'cpf',
        'telefone'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'deleted_at',
        'dt_nascimento'
    ];

    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = [];
}

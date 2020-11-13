<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Magic Methods
 * @property string started_at
 * @property string finished_at
 * @property HasOne Unit
 * Class UnitCharge
 * @package App
 */
class UnitCharge extends Model
{
    public $timestamps = true;

    /**
     * @var array
     */
    protected $fillable = [
        'unit_id',
        'started_at',
        'finished_at'

    ];

    /**
     * @var array
     */
    protected $casts = [

        'started_at' => 'string',
        'finished_at' => 'string'

    ];

    /**
     * @return HasOne|Collection
     */
    public function Unit() {

        return $this->hasOne( 'App\Unit', 'id','unit_id');

    }
}

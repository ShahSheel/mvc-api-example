<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Magic Methods
 * @property string name
 * @property string address
 * @property string postcode
 * @property boolean status
 * @property HasMany Charges
 * Class Unit
 * @package App
 */
class Unit extends Model
{
    public $timestamps = true;

    /**
     * @var array
     */
    protected $fillable = [

        'name',
        'address',
        'postcode',
        'status'

    ];

    /**
     * @var array
     */
    protected $casts = [

        'name' => 'string',
        'address' => 'string',
        'postcode'=> 'string',
        'status' => 'string'

    ];


    /**
     * @return HasMany|Collection
     */
    public function Charges() {

        return $this->hasMany( 'App\UnitCharge', 'unit_id', 'id');

    }
}

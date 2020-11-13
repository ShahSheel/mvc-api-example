<?php

namespace App\Http\Controllers\Api;

use App\Unit;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Builder;

/** Request validations */

class GetUnitsController extends Controller
{

    const UNIT_CHARGES_MODEL = 'charges';

    /**
     * Path: /units
     * Method: GET
     * @return Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    protected function getAllUnits(){

        // Use Eloquent of Charges to fetch all data per Unit ID
        return Unit::query()->with(self::UNIT_CHARGES_MODEL )->get();
    }

    /**
     * Path: Unit/{UnitID}
     * Method: GET
     * @param Request $request
     * @param $unitID
     * @param Builder $Builder
     * @return Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    protected function getUnit(Request $request, $unitID){
        // Use Eloquent of Charges to fetch all data per Unit ID

        return Unit::with(self::UNIT_CHARGES_MODEL )->where('id', $unitID )->get();

    }


}

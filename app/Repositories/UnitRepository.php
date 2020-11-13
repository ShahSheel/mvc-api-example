<?php

namespace App\Repositories;
use App\Unit;
use App\UnitCharge;

class UnitRepository implements IUnitRepository
{


    const UNIT_CHARGES_MODEL = 'charges';
    const UNIT_CHARGES_MODEL__UNIT_ID = 'unit_id';
    const CREATE_CHARGE = 'avaliable';
    const STOP_CHARGE = 'charging';
    const UNIT_MODEL = 'Unit';


    /**
     * GET -> v2\Units
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getAllUnits(){

        return Unit::query()->with(self::UNIT_CHARGES_MODEL )->get();

    }

    /**
     *  GET -> v2\Units\{UnitID}
     * @param $id
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getUnitsByID( $id )
    {
        return Unit::query()->with(self::UNIT_CHARGES_MODEL )->where('id', $id )->get();

    }

    /**
     *  POST -> v2\Units\{UnitID}\Charges
     * @param $id
     * @param $chargeID
     * @param $status
     * @param $timestamp
     */
    public function startCharge( $id, $chargeID, $status, $timestamp )
    {
        UnitCharge::query()->create([
            self::UNIT_CHARGES_MODEL__UNIT_ID => $id,
            'started_at' => $timestamp,
            'finished_at' => null
        ]);

        $this->updateUnitStatus( $id, $this->toggleUnitStatus( $status ) );


    }

    /**
     *  POST v2\Units\{UnitID}\Charges\{ChargeID}
     * @param $id
     * @param $chargeID
     * @param $status
     * @param $timestamp
     */
    public function stopCharge( $id, $chargeID, $status, $timestamp )
    {

        UnitCharge::query()->whereHas(self::UNIT_MODEL, function ($query) use ($id, $chargeID, $status) {
            $query
                ->where('unit_charges.id', $chargeID)
                ->where('units.id', $id)
                ->where('units.status', 'charging');

        })->update([
            'finished_at' => $timestamp
        ]);

        $this->updateUnitStatus( $id, $this->toggleUnitStatus( $status ) );

    }

    /**
     * Toggle status avaliability
     * @param $status
     * @return string
     */
    private function toggleUnitStatus( $status ){

    // Not using turnary here just for readability
        if($status == self::STOP_CHARGE ){
            return self::CREATE_CHARGE; // Switch status
        }
        if($status == self::CREATE_CHARGE ){
            return self::STOP_CHARGE;
        }

    }


    /**
     * Update the child Units status
     * @param $id
     * @param $status
     */
    private function updateUnitStatus( $id, $status ){


        Unit::query()->where('id', $id )->update(['status' =>  $status ]);

    }


}

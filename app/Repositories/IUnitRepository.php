<?php


namespace App\Repositories;

interface IUnitRepository
{
    public function getAllUnits();

    public function getUnitsByID( $id );

    public function startCharge( $id, $chargeID, $status, $timestamp );

    public function stopCharge ( $id, $chargeID, $status, $timestamp );

}

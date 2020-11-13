<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Repositories\IUnitRepository;

class UnitController extends Controller
{

    protected $_unit  = null;
    const START_CHARGE = 'avaliable'; // Status check
    const STOP_CHARGE = 'charging'; // Status check
    const UNIT_CHARGES_MODEL = 'charges';


    /**
     * Use the interface object thats binded to its class
     * UnitController constructor.
     * @param IUnitRepository $unit
     */
    public function __construct(  IUnitRepository $unit )
    {
        // Create the repo object
        $this->_unit = $unit;
    }

    /**
     * Get all the units
     * @return mixed
     */
    public function getAllUnits()
    {
       return  $this->_unit->getAllUnits();
    }

    /**
     * Get a unit by ID
     * @param $unitID
     * @return mixed
     */
    public function getUnitByID( $unitID  )
    {
        return  $this->_unit->getUnitsByID( $unitID );

    }

    /**
     * Create a charge and use the body as the start time
     * @param Request $request
     * @param $unitID
     * @param $chargeID
     * @param string $status
     */
    public function startCharge( Request $request, $unitID, $chargeID, $status=self::START_CHARGE )
    {

         $this->_unit->startCharge($unitID,$chargeID,$status,$request->input('started_at') );

    }

    /**
     * Stop a charge and use the body as the stop time
     * @param Request $request
     * @param $unitID
     * @param $chargeID
     * @param string $status
     */
    public function stopCharge( Request $request, $unitID, $chargeID, $status=self::STOP_CHARGE  )
    {
       $this->_unit->stopCharge( $unitID,$chargeID,$status,$request->input('finished_at') );

    }



}

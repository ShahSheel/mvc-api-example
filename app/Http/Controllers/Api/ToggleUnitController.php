<?php

namespace App\Http\Controllers\Api;


use App\Unit;
use App\UnitCharge;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Code;
use DateTime;
use Exception;


class ToggleUnitController extends Controller
{

    /** @json */
    private $_jsonRequest;

    /** @string */
    private $_unit_charge_time_stamp;

    const UNIT_CHARGES_MODEL__UNIT_ID = 'unit_id';
    const UNIT_MODEL = 'Unit';

    const CREATE_CHARGE = 'avaliable'; // Status needs to be avaliable (1)
    const STOP_CHARGE = 'charging'; // Status needs to be charging (0)
    /** @string  */
    const RFC3339_EXTENDED = "/^([0-9]+)-(0[1-9]|1[012])-(0[1-9]|[12][0-9]|3[01])[Tt]([01][0-9]|2[0-3]):([0-5][0-9]):([0-5][0-9]|60)(\.[0-9]+)?(([Zz])|([\+|\-]([01][0-9]|2[0-3]):[0-5][0-9]))$/";

    /**
     * @param Request $request
     * @param $unitID
     * @param $status
     * @throws Exception
     */
    private function handle( Request $request, $unitID, $status ){


       try {

        $this
            -> jsonDecodeRequest( $request )
            -> checkJson()
            -> checkDateTimeString ($this->_jsonRequest)
            -> checkUnit( $unitID )
            -> methodCallCheck();


       }catch(Exception $exception ){
           throw new HttpResponseException($exception->getMessage(),$exception->getCode());
        }


    }


    /**
     * Decode the request to json
     * @param Request $request
     * @return $this
     */
    private function jsonDecodeRequest( Request $request ){
        $this->_jsonRequest =  json_decode ( $request->getContent() );

        // Make chainable
        return $this;

    }

    private function checkJson(){

     if ( is_null( $this->_jsonRequest ) || empty( $this->_jsonRequest ) ){

         throw new Exception('Empty Request',Code::STATUS_BAD_ENTITY);

     }
     return $this;

    }

    /**
     * In case user tries to intercept the request and modify it!
     * @param $jsonRequest
     * @return $this|JsonResponse
     * @throws Exception
     */
    private function checkDateTimeString( $jsonRequest ){

        if( isset($jsonRequest->started_at ) ) {
            $this->_unit_charge_time_stamp = $this->validateRFC3339_EXTENDED( $jsonRequest->started_at );
            return $this;

        }

       else{
           $this->_unit_charge_time_stamp = $this->validateRFC3339_EXTENDED( $jsonRequest->finished_at );

           return $this;

        }

    }


    /** Validation (Needs to be in another class) **/
    private function validateRFC3339_EXTENDED( $chargeDateTime ){

       $valid = preg_match(self::RFC3339_EXTENDED, $chargeDateTime );

       if ($valid){
           return $chargeDateTime;
       }

     throw new Exception('Unprocessable Entity (validation failed)',Code::STATUS_BAD_ENTITY);


    }


    private function checkUnit( $unitID ){

        // Merged into 1 query and giving bad request error.
        if ($unitID == null
            || Unit::query()->where('id', $unitID)
                ->where('status', 'charging')
                ->orwhere('status', 'avaliable')
                ->doesntExist() ) {

            throw new Exception('Invalid Unit ID ',Code::STATUS_BAD_ENTITY);

        }

        if ( isset(  $this->_jsonRequest->started_at ) &&
            Unit::query()->where('id', $unitID)->where('status', 'charging')
                ->orwhere('status', 'charging')
                ->exists() ) {

            throw new Exception('Unit already charging! ',Code::STATUS_BAD_ENTITY);

        }

        return $this;

    }


    private function methodCallCheck(){
    }

    /**
     * Path: units/{unitID}/charges
     * Method: POST
     * @param Request $request
     * @param $unitID
     * @param string $status
     * @return JsonResponse
     * @throws Exception
     */
    protected function startUnitCharge( Request $request, $unitID, $status=self::CREATE_CHARGE  )
    {

       // $this->handle( $request, $unitID, $status );

        UnitCharge::create([
            self::UNIT_CHARGES_MODEL__UNIT_ID => $unitID,
            'started_at' => $request->input('started_at'),
            'finished_at' => null
        ]);


        // Assume it's been created then update the Unit with the opposite status
        $this->updateUnitStatus( $unitID, $this->toggleUnitStatus( $status ) );

        return new JsonResponse(['message' => 'Success'], code::OK);

    }

    /**
     * Path: units/{unitID}/charges/{chargeID}
     * Method: PUT
     * @param Request $request
     * @param $unitID
     * @param $chargeID
     * @param string $status
     * @return mixed
     * @throws Exception
     */
    protected function stopUnitCharge(  Request $request, $unitID, $chargeID, $status=self::STOP_CHARGE ){

        // For some reason Requests is returning NULL in Laravel 6.3 (Bug perhaps?)

            UnitCharge::whereHas(self::UNIT_MODEL, function ($query) use ($unitID, $chargeID, $status) {
                $query
                    ->where('unit_charges.id', $chargeID)
                    ->where('units.id', $unitID)
                    ->where('units.status', 'charging');

            })->update([
                'finished_at' => $request->input('finished_at')
            ]);

            $this->updateUnitStatus($unitID, $this->toggleUnitStatus($status));
    //    }

        return new JsonResponse(['message' => 'Success'], code::OK);

    }


    private function toggleUnitStatus( $status ){

        // Toggle the value. EG: If its coming from "Avaliable", switch value to 0

        if($status == self::STOP_CHARGE ){
            return self::CREATE_CHARGE;
        }
        if($status == self::CREATE_CHARGE ){
            return self::STOP_CHARGE;
        }
    }


    private function updateUnitStatus( $unitID, $status ){


        Unit::query()->where('id', $unitID)->update(['status' =>  $status ]);

    }


}

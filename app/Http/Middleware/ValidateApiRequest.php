<?php

namespace App\Http\Middleware;

use Closure;

class ValidateApiRequest
{

    /* @string */
    private $_actionName;

    /* @array */
    private $_parameters = [];

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        // Check validity based on getActionMethodName

//        $this
//            -> setActionMethod( $request->route()->getActionName() )
//            -> setHTTPParameters( $request->route()->parameters() )
//
//        ;
        return $next($request);
    }

    /**
     * Get Action Name
     * @param $actionName
     * @return $this
     */
    private function setActionMethod ( $actionName ){

        //Store action name
        $this->_actionName = $actionName;

        // Make chainable
        return $this;
    }

    /**
     * Set Parameters from HTTP request
     * @param $parameters
     * @return $this
     */
    private function setHTTPParameters ( $parameters ){

        //Store parameters (Type array)
        $this->_parameters = $parameters;

        // Make chainable
        return $this;
    }

    private function validate(){

        // Validate based on action name
        switch (  $this->_actionName ){

            case "getAllUnits":
                $this->validateGetAllUnits();
                break;

            case "getUnit":
                $this->validateGetUnit();
                break;

            case "createUnitCharge":
                $this->validateCreateUnitCharge();
                break;

            case "stopUnitCharge":
                $this->validateStopUnitCharge();
                break;

            default:
                echo "No information available for that day.";
                break;

        }

        return $this;
    }

//
//    private function validateGetAllUnits(){
//
//    }
//
//    private function validateGetUnit(){
//
//    }
//
//
//    private function validateCreateUnitCharge(){
//
//    }
//
//    private function validateStopUnitCharge(){
//
//    }


}

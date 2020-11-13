<?php

use Illuminate\Database\Seeder;

use App\Unit;

class SeedUnitsCharges extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    /* @var array */
    private $_data = [];
    public function run()
    {

        $this
            -> seedUnits() //Seed Units
            -> seedCharges() // Seed Charges
        ;

    }

    private function seedUnits(){
       $this->_data  = [

            [
                'name' => 'Office',
                'address' => 'Discovery House, 28–42 Banner Street',
                'postcode' => 'EC1Y 8QE',
                'status' => 'avaliable',
            ],

            [
                'name' => 'Horseferry Road',
                'address' => 'Horseferry Road',
                'postcode' => 'SW1P 2AF',
                'status' => 'avaliable',
            ],

            [
                 'name' => 'Putney Exchange Shopping Center',
                 'address' => 'Putney High St',
                 'postcode' => 'SW1P 2AF',
                 'status' => 'charging'
             ],
        ];

        // Insert
        DB::table( 'units' )->insert(   $this->_data  );

        // Make chainable
        return $this;
    }

    private function seedCharges(){

        $this->_data  = [

                [
                    'unit_id' => 3,
                    'started_at' => '2000-07-20T07:12:30+00:00',
                    'finished_at' => '2010-06-18T13:12:52+00:00'
                ],

                [
                'unit_id' => 3,
                'started_at' => '2014-03-25 19:03',
                'finished_at' => '2020-03-25 19:03'
                ],

                [
                'unit_id' => 3,
                'started_at' => '2010-03-25 19:03',
                'finished_at' => '2011-03-25 19:03'
                ]
            ];

        // Insert
        DB::table( 'unit_charges' )->insert(   $this->_data  );

        // Make chainable
        return $this;

    }



}


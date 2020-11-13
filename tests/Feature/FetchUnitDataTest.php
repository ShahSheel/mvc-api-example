<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\User;

class FetchUnitDataTest extends TestCase
{
    /** @test */
    public function fetchUnitsTest()
    {

        $response = $this->get('api/v1/units/');

        if($response === null ){
            $response->assertStatus(400);
        }
        $response->assertStatus(200);
    }

    /** @test */
    public function fetchUnitByIDTest()
    {
        $response = $this->get('api/v1/units/' . 1 );

        if($response === null ){
            $response->assertStatus(400);
        }
        $response->assertStatus(200);
    }

    /** @test  */
    public function loginTest(){
        $credential = [
            'email' => 'hello@example.net',
            'password' => '1234'
        ];
        $response = $this->post('api/login',$credential);

        if( $response === null ){
            $response->assertStatus(400);

        }
        $response->assertStatus(200);

    }


}

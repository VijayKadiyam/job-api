<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\UserSale;

class UserSaleTest extends TestCase
{
  use DatabaseTransactions;
  
  public function setUp()
  {
    parent::setUp();

    factory(\App\UserSale::class)->create([
      'user_id'  =>  $this->user->id 
    ]);

    $this->payload = [ 
      'date'        =>  '02-01-2019',
      'amount'      =>  '50'
    ];
  }

  /** @test */
  function user_must_be_logged_in_before_accessing_the_controller()
  {
    $this->json('post', '/api/user_sales')
      ->assertStatus(401); 
  }

  /** @test */
  function it_requires_following_details()
  {
    $this->json('post', '/api/user_sales', [], $this->headers)
      ->assertStatus(422)
      ->assertExactJson([
          "errors"  =>  [
            "date"    =>  ["The date field is required."],
            "amount"  =>  ["The amount field is required."]
          ],
          "message" =>  "The given data was invalid."
        ]);
  }

  /** @test */
  function add_new_user_attendance()
  {
    $this->disableEH();
    $this->json('post', '/api/user_sales', $this->payload, $this->headers)
      ->assertStatus(201)
      ->assertJson([
          'data'   =>[
            'date'        =>  '02-01-2019',
            'amount'      =>  '50'       
          ]
        ])
      ->assertJsonStructureExact([
          'data'   => [
            'date',
            'amount',
            'user_id',
            'updated_at',
            'created_at',
            'id'
          ]
        ]);
  }

  /** @test */
  function list_of_user_sales()
  {
    $this->json('GET', '/api/user_sales',[], $this->headers)
      ->assertStatus(200)
      ->assertJsonStructure([
          'data' => [
            0 =>  [
              'date',
              'amount'
            ] 
          ]
        ]);
    $this->assertCount(1, UserSale::all());
  }

  /** @test */
  function show_single_user_sale()
  {
    $this->json('get', "/api/user_sales/1", [], $this->headers)
      ->assertStatus(200)
      ->assertJson([
          'data'  => [
            'date'        =>  '01-01-2019',
            'amount'      =>  '20'          ]
        ]);
  }

  /** @test */
  function update_single_user_attendance()
  {
    $payload = [ 
      'date'        =>  '02-01-2019',
      'amount'      =>  '30' 
    ];

    $this->json('patch', '/api/user_sales/1', $payload, $this->headers)
      ->assertStatus(200)
      ->assertJson([
          'data'    => [
            'date'        =>  '02-01-2019',
            'amount'      =>  '30' 
          ]
       ])
      ->assertJsonStructureExact([
          'data'  => [
            'id',
            'user_id',
            'date',
            'amount',
            'created_at',
            'updated_at',
          ]
      ]);
  }
}

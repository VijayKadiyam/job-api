<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Company;
use App\Practice;
use App\User;

class PracticeTest extends TestCase
{
  use DatabaseTransactions;

 public function setUp() : void
 {
    parent::setUp();

    $this->company = factory(\App\Company::class)->create([
           'name' => 'test'
    ]);

    $this->user->assignCompany($this->company->id);

    $this->headers['company-id'] = $this->company->id;


    $this->practice = factory(\App\Practice::class)->create([
      'company_id'  =>  $this->company->id,
    ]);

    $this->payload = [ 
      'name'           =>  'name',     
    ];
  }

  /** @test */
  function user_must_be_logged_in_before_accessing_the_controller()
  {
      $this->json('post', '/api/practices')
        ->assertStatus(401); 
  }

   /** @test */
  function it_requires_following_details()
  { 
     $this->json('post', '/api/practices', [], $this->headers)
        ->assertStatus(422)
        ->assertExactJson([
       "errors"       =>  [
        "name"        =>  ["The name field is required."],      
      ],
        "message"     =>  "The given data was invalid."
      ]);
  }

  /** @test */
  function add_new_practices()
  {   $this->disableEH();
      $this->json('post', '/api/practices', $this->payload, $this->headers)
        ->assertStatus(201)
        ->assertJson([
            'data'   =>[
              'name'  =>  'name',
            ]
          ])
        ->assertJsonStructureExact([
            'data'   => [
                'name',              
                'company_id',
                'updated_at',
                'created_at',
                'id'
            ],
            'success'
          ]); 
  }

  /** @test */
  function list_of_practices()
  {
    $this->json('GET', '/api/practices',[], $this->headers)
      ->assertStatus(200)
      ->assertJsonStructure([
          'data' => [
            0 => [
              'name',              
            ] 
          ]
        ]);
        $this->assertCount(1, Practice::all());
  }


  /** @test */
  function show_single_practice()
  {
    $this->json('get', "/api/practices/1", [], $this->headers)
      ->assertStatus(200)
      ->assertJson([
          'data'  => [
              'name' =>  'Vijay',
          ]
        ]);
  }

  /** @test */
  function update_single_practice()
    {
      $this->disableEH();
      $payload  = [
        'name'                 => 'Name Must Updated',
      ];

      $this->json('patch', '/api/practices/1', $payload, $this->headers)
        ->assertStatus(200)
        ->assertJson([
            'data'    => [
              'name'    => 'Name Must Updated',

            ]
         ])
        ->assertJsonStructureExact([
            'data'  => [
              'id',
              'company_id',
              'name',
              'created_at',
              'updated_at',
              
              ] 
          ]);
  }

  /** @test */
  function delete_single_practice()
  {
      $this->json('delete', '/api/practices/1', [], $this->headers)
        ->assertStatus(200);     
      $this->assertCount(0, Practice::all());
  }

}

<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Branch;
use App\User;

class BranchTest extends TestCase
{
  use DatabaseTransactions;

  public function setUp() : void
  {
    parent::setUp();
    $this->user = factory(User::class)->create();
    
    $this->branch = factory(Branch::class)->create([
      'user_id'  =>  $this->user->id
    ]);

        $this->payload = [
            'name'      => 'xyz',  
        ];
  }
   /** @test */
  function add_requires_following_details()
  {                          
    $this->json('POST', '/api/users/' . $this->user->id . '/branches', [], $this->headers)
      ->assertStatus(422)
      ->assertExactJson([
          "errors" => [
            "name"    =>  ["The name field is required."],       
        ],
         "message" =>"The given data was invalid."
        ]);
  }

    /** @test */
  function add_new_branch()
  {
    $this->json('POST', '/api/users/' . $this->user->id . '/branches' , $this->payload,$this->headers)
         ->assertStatus(201)
         ->assertJson([
            "data"  => [
                "name"  => "xyz",
                 ]
            ])
          ->assertJsonStructureExact([
            'data'  =>  [
            'name',
            'user_id',
            'updated_at',
            'created_at',
            'id',
            ]
        ]);
  }
    /** @test */
  function list_of_branches()
  {
    $this->json('GET' , '/api/users/' . $this->user->id . '/branches' , $this->payload,$this->headers)
         ->assertStatus(200)
         ->assertJson([
            "data" => [
                0 => [
                    "name" => "Vijay",
                    
                 ]
                ] 
             ]);

    $this->assertCount(1,Branch::all());

   }

   /** @test */
  function show_single_branch()
  {
    $this->json('get',  '/api/users/' . $this->user->id . '/branches/' . $this->branch->id,[],$this->headers)
        ->assertStatus(200)
        ->assertJson([
            'data' => [
                'name' => 'Vijay',   
             ]
         ]);
  }

   /** @test */
  function update_requires_folliowing_details()
  {
    $this->json('patch',  '/api/users/' . $this->user->id . '/branches/' . $this->branch->id, [],$this->headers)
        ->assertStatus(422)
        ->assertExactJson([
            "errors"  =>  [
         "name"    =>  ["The name field is required."],       
        ],
         "message" => "The given data was invalid."
        ]);
  }          

   /** @test */
  function update_single_branch()
  {
      $payload  = [
      'name'  =>  'rice Updated',    
    ];

    $this->json('patch', '/api/users/' . $this->user->id . '/branches/' . $this->branch->id, $payload,$this->headers)
      ->assertStatus(200)
      ->assertJson([
          'data' => [
            'name'    => 'rice Updated',
          ]
      ])
      ->assertJsonStructureExact([
          'data'  =>  [
             'id',
             'user_id',
             'name',
             'created_at',
             'updated_at',     
          ]
        ]);    

  }

  /** @test */
  function delete_single_branch()
  {
    $this->json('delete',  '/api/users/' . $this->user->id . '/branches/' . $this->branch->id, [],$this->headers)
    ->assertStatus(200);

     $this->assertCount(0, Branch::all());
         
  }
}

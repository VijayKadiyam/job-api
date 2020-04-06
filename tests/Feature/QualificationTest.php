<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Company;
use App\Qualification;
use App\User;

class QualificationTest extends TestCase
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

    $this->qualification = factory(\App\Qualification::class)->create([
      'company_id'  =>  $this->company->id,
    ]);

    $this->payload = [ 
      'name'  =>  'name',     
    ];
  }

  /** @test */
  function user_must_be_logged_in_before_accessing_the_controller()
  {
    $this->json('post', '/api/qualifications')
      ->assertStatus(401); 
  }
  /** @test */
  function list_of_qualifications()
  {
    $this->json('GET', '/api/qualifications',[], $this->headers)
      ->assertStatus(200)
      ->assertJsonStructure([
          'data' => [
            0 => [
              'name',              
            ] 
          ]
        ]);
    $this->assertCount(1, Qualification::all());
  }


  /** @test */
  function list_of_qualifications_of_a_page()
  {
    $this->disableEH();
    factory(\App\Qualification::class)->create([
      'company_id' =>  $this->company->id
    ]);

    $this->json('GET', '/api/qualifications?page=1&rowsPerPage=5', [], $this->headers)
         ->assertStatus(200)
         ->assertJsonStructure([
            'data' => [
              0=>[
                'name'
              ] 
            ]
        ]);
    $this->assertCount(2, Qualification::all());
  }

  /** @test */
  public function list_of_qualifications_of_a_search()
  {
    $this->disableEH();
    factory(\App\Qualification::class)->create([
      'company_id' =>  $this->company->id
    ]);

    $this->json('GET', '/api/qualifications?search=' . $this->qualification->name, [], $this->headers)
         ->assertStatus(200)
         ->assertJsonStructure([
            'data' => [
              0=>[
                'name'
              ] 
            ]
        ]);
  }

   /** @test */
  function it_requires_following_details()
  { 
    $this->json('post', '/api/qualifications', [], $this->headers)
      ->assertStatus(422)
      ->assertExactJson([
     "errors"       =>  [
      "name"        =>  ["The name field is required."],      
    ],
      "message"     =>  "The given data was invalid."
    ]);
  }

  /** @test */
  function add_new_qualifications()
  {  
    $this->json('post', '/api/qualifications', $this->payload, $this->headers)
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
  function show_single_qualification()
  {
    $this->json('get', "/api/qualifications/1", [], $this->headers)
      ->assertStatus(200)
      ->assertJson([
          'data'  => [
              'name' =>  'Vijay',
          ]
        ])
         ->assertJsonStructureExact([
            'data'   => [
                'id',
                'company_id',
                'name',
                'created_at',
                'updated_at',
            ],
            'success'
          ]); 
  }

    /** @test */
  function update_single_qualifications()
  {
    $this->disableEH();
      $payload  = [
        'name'    => 'Name Must Updated',
      ];

    $this->json('patch', '/api/qualifications/1', $payload, $this->headers)
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
            ],
            'success'
        ]);
  }

  /** @test */
  function delete_single_qualification()
  {
    $this->json('delete', '/api/qualifications/1', [], $this->headers)
      ->assertStatus(200);     
    $this->assertCount(0, Qualification::all());
  }
}

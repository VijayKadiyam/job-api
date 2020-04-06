<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Company;
use App\Affiliation;
use App\User;

class AffiliationTest extends TestCase
{
   use DatabaseTransactions;

  public function setUp() : void
  {
    parent::setUp();

    $this->company = factory(\App\Company::class)->create([
           'name'  => 'test'
    ]);

    $this->user->assignCompany($this->company->id);

    $this->headers['company-id'] = $this->company->id;

    $this->affiliation = factory(\App\Affiliation::class)->create([
      'company_id'     =>  $this->company->id,
    ]);

    $this->payload = [ 
      'name'           =>  'name',     
    ];
  }

  /** @test */
  function user_must_be_logged_in_before_accessing_the_controller()
  {
    $this->json('post', '/api/affiliations')
        ->assertStatus(401); 
  }
/** @test */
  function list_of_affiliations()
  {
    $this->json('GET', '/api/affiliations',[], $this->headers)
      ->assertStatus(200)
      ->assertJsonStructure([
          'data' => [
            0 => [
              'name',              
            ] 
          ]
        ]);
    $this->assertCount(1, Affiliation::all());
  }
  /** @test */
  function list_of_affiliations_of_a_page()
  {
    $this->disableEH();
    factory(\App\Affiliation::class)->create([
      'company_id' =>  $this->company->id
    ]);

    $this->json('GET', '/api/affiliations?page=1&rowsPerPage=5', [], $this->headers)
         ->assertStatus(200)
         ->assertJsonStructure([
            'data' => [
              0=>[
                'name'
              ] 
            ]
        ]);
    $this->assertCount(2, Affiliation::all());
  }

  /** @test */
  public function list_of_affiliations_of_a_search()
  {
    $this->disableEH();
    factory(\App\Affiliation::class)->create([
      'company_id' =>  $this->company->id
    ]);

    $this->json('GET', '/api/affiliations?search=' . $this->affiliation->name, [], $this->headers)
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
    $this->json('post', '/api/affiliations', [], $this->headers)
        ->assertStatus(422)
        ->assertExactJson([
       "errors"       =>  [
        "name"        =>  ["The name field is required."],      
      ],
        "message"     =>  "The given data was invalid."
      ]);
  }

  /** @test */
  function add_new_affiliations()
  {  
    $this->json('post', '/api/affiliations', $this->payload, $this->headers)
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
  function show_single_affiliation()
  {
    $this->json('get', "/api/affiliations/1", [], $this->headers)
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
  function update_single_affiliations()
    {
      $this->disableEH();
      $payload  = [
        'name'                 => 'Name Must Updated',
      ];

      $this->json('patch', '/api/affiliations/1', $payload, $this->headers)
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
              ] ,
              'success'
          ]);
  }

  /** @test */
  function delete_single_affiliation()
  {
    $this->json('delete', '/api/affiliations/1', [], $this->headers)
      ->assertStatus(200);     
    $this->assertCount(0, Affiliation::all());
  }


}

<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\OfficeTiming;
use App\User;

class OfficeTimingTest extends TestCase
{
  use DatabaseTransactions;

  public function setUp() : void
  {
    parent::setUp();

    $this->user = factory(User::class)->create();

    $this->office_timing = factory(OfficeTiming::class)->create([
     'user_id'  =>  $this->user->id
    ]);

    $this->payload = [
        'from'        =>  'from1',
        'from_am_pm'  =>  'from am pm1',
        'to'          =>  'to1',
        'to_am_pm'    =>  'to am pm1' 
      ];
  }

  /** @test */
  function add_requires_following_details()
  {
    $this->json('POST', '/api/users/' . $this->user->id . '/office_timings', [],$this->headers)
      ->assertStatus(422)
      ->assertExactJson([
        "errors" => [
          "from"    =>  ["The from field is required."],   
          "to"      =>  ["The to field is required."],       
         ],
       "message" =>"The given data was invalid."
      ]);
  }

  /** @test */
  function add_new_office_timing()
  {
    $this->disableEH();

    $this->json('POST', '/api/users/' . $this->user->id . '/office_timings' , $this->payload,$this->headers)
      ->assertStatus(201)
      ->assertJson([
          "data"  => [
              'from'        =>  'from1',
           ]
         ])
        ->assertJsonStructureExact([
            'data'  =>  [
              'from',
              'from_am_pm',
              'to',
              'to_am_pm',
              'user_id',
              'updated_at',
              'created_at',
               'id',
            ],
            'success'
        ]);
  }
    /** @test */
  function list_of_office_timings()
  {
    $this->json('GET' , '/api/users/' . $this->user->id . '/office_timings' , $this->payload,$this->headers)
      ->assertStatus(200)
      ->assertJsonStructure([
          "data" => [
              0 => [
                  'from',
                  'from_am_pm',
                  'to',
                  'to_am_pm',
                  ]
                ] 
           ]);
    $this->assertCount(1,OfficeTiming::all());
  }

  /** @test */
  function show_single_office_timings()
  {
    $this->json('get',  '/api/users/' . $this->user->id . '/office_timings/' . $this->office_timing->id,[],$this->headers)
      ->assertStatus(200)
      ->assertJson([
          'data' => [
              'from'        =>  'from',
              'from_am_pm'  =>  'from am pm',
              'to'          =>  'to',
              'to_am_pm'    =>  'to am pm'
             ]
       ])
        ->assertJsonStructureExact([
            'data'  =>  [
              'id',
              'user_id',
              'from',
              'from_am_pm',
              'to',
              'to_am_pm',
              'created_at',
              'updated_at',
            ],
            'success'
        ]);
  }

   /** @test */
  function update_requires_folliowing_details()
  {
    $this->json('patch',  '/api/users/' . $this->user->id . '/office_timings/' . $this->office_timing->id, [],$this->headers)
      ->assertStatus(422)
      ->assertExactJson([
          "errors"  =>  [
             "from"    =>  ["The from field is required."],   
             "to"      =>  ["The to field is required."],       
           ],
        "message" => "The given data was invalid."
      ]);
  }          

 /** @test */
  function update_single_office_timing()
  {
    $payload  = [
        'from'        =>  'from',
        'from_am_pm'  =>  'from am pm',
        'to'          =>  'to',
        'to_am_pm'    =>  'to am pm'   
     ];

     $this->json('patch', '/api/users/' . $this->user->id . '/office_timings/' . $this->office_timing->id, $payload,$this->headers)
      ->assertStatus(200)
      ->assertJson([
        'data' => [
          'from'        =>  'from',
          'from_am_pm'  =>  'from am pm',
          'to'          =>  'to',
          'to_am_pm'    =>  'to am pm'
        ]
    ])
    ->assertJsonStructureExact([
        'data'  =>  [
          'id',
          'user_id',
          'from',
          'from_am_pm',
          'to',
          'to_am_pm',
          'created_at',
          'updated_at',
        ],
        'success'
      ]);    
  }

  /** @test */
  function delete_single_office_timing()
  {
    $this->json('delete',  '/api/users/' . $this->user->id . '/office_timings/' . $this->office_timing->id, [],$this->headers)
      ->assertStatus(200);

    $this->assertCount(0, OfficeTiming::all());
  }


}

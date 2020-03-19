<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\User;
use App\Day;

class UserDayTest extends TestCase
{
    use DatabaseTransactions;

  /** @test */
  function it_requires_following_details()
  {
    $this->json('post', '/api/user_day', [])
      ->assertStatus(422)
      ->assertExactJson([
          "errors"     =>  [
            "user_id"         =>  ["The user id field is required."],
            "day_id"          =>  ["The day id field is required."]
          ],
          "message"      =>  "The given data was invalid."
        ]);
  }

   /** @test */
  function assign_user()
  { 

    $DayTwo  = factory(\App\Day::class)->create();
    $user  = factory(\App\User::class)->create();
    $DayTwo->assignUser(1);
    $check    = $DayTwo->hasUser(1);
    $this->assertTrue($check);
  }
    /** @test */
  function assign_day_to_user()
 {
    $this->disableEH();
    $dayTwo       = factory(\App\Day::class)->create();
    $user  = factory(\App\User::class)->create();
    $this->payload = [ 
      'day_id'    => $dayTwo->id,
      'user_id'   => 1
    ];

    $this->json('post', '/api/user_day', $this->payload)
      ->assertStatus(201)
      ->assertJson([
          'data'  =>  [
            'name'                    =>  $dayTwo->name,
            'users'                 =>  [
              0 =>  [
                'name' => 'Vijaykumar Kadiyam',
              ]
            ]
          ]
        ])
      ->assertJsonStructureExact([
        'data'  =>  [
          'id',
          'company_id',
          'name',
          'created_at',
          'updated_at',
          'users',
        ],
        'success'
      ]);
  }
}

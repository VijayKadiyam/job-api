<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UserPracticeTest extends TestCase
{
  use DatabaseTransactions;

  /** @test */
  function user_requires_business_and_user()
  {
    $this->json('post', '/api/user_practice', [], $this->headers)
      ->assertStatus(422)
      ->assertExactJson([
          "errors"     =>  [
            "user_id"  =>  ["The user id field is required."],
            "practice_id"      =>  ["The practice id field is required."]
          ],
          "message"        =>  "The given data was invalid."
        ]);
  }

   /** @test */
  function assign_user()
  { 

    $PracticeTwo  = factory(\App\Practice::class)->create();
    $user  = factory(\App\User::class)->create();
    $PracticeTwo->assignUser(1);
    $check    = $PracticeTwo->hasUser(1);
    $this->assertTrue($check);
  }

     /** @test */
  function assign_user_to_practice()
  {
    $this->disableEH();
    $practiceTwo = factory(\App\Practice::class)->create();
    $user = factory(\App\User::class)->create();
    $this->payload      = [ 
      'practice_id'    => $practiceTwo->id,
      'user_id' => $user->id
    ];
    $this->json('post', '/api/user_practice', $this->payload , $this->headers)
      ->assertStatus(201)
      ->assertJson([
            'data'  =>  [
              'name'                    =>  $practiceTwo->name,
              'users'                   =>  [
                0 =>  [
                  'email'  =>  $user->email
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

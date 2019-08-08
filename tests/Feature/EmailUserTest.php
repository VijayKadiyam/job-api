<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class EmailUserTest extends TestCase
{
  use DatabaseTransactions;

  public function setUp()
  {
    parent::setUp();

    $this->company = factory(\App\Company::class)->create([
      'name' => 'test'
    ]);
    $this->user->assignCompany($this->company->id);
    $this->headers['company-id'] = $this->company->id;
  }

  /** @test */
  function user_requires_role_and_user()
  {
    $this->json('post', '/api/product_user', [], $this->headers)
      ->assertStatus(422)
      ->assertExactJson([
          "errors"     =>  [
            "product_id"  =>  ["The product id field is required."],
            "user_id"  =>  ["The user id field is required."]
          ],
          "message"    =>  "The given data was invalid."
        ]);
  }

  /** @test */
  function assign_email()
  {
    $userTwo  = factory(\App\User::class)->create();
    $userTwo->assignEmail();
    $check    = $userTwo->hasEmail();
    $this->assertTrue($check);
  }

}

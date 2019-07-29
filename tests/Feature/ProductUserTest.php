<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ProductUserTest extends TestCase
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

    $this->listing = factory(\App\Listing::class)->create([
      'company_id'  =>  $this->company->id 
    ]);

    $this->product = factory(\App\Product::class)->create([
      'listing_id'  =>  $this->listing->id 
    ]);

    $this->payload = [ 
      'name'     =>  'Product 2',
      'position'  =>  1
    ];
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
  function assign_product()
  {
    $userTwo  = factory(\App\User::class)->create();
    $userTwo->assignProduct($this->product->id);
    $check    = $userTwo->hasProduct($this->product->id);
    $this->assertTrue($check);
  }

  /** @test */
  function assign_product_to_user()
  {
    $this->disableEH();
    $userTwo       = factory(\App\User::class)->create();
    $this->payload = [ 
      'user_id'       => $userTwo->id,
      'product_id'    => $this->product->id
    ];
    $this->json('post', '/api/product_user', $this->payload)
      ->assertStatus(201)
      ->assertJson([
          'data'  =>  [
            'name'                    =>  $userTwo->name,
            'phone'                   =>  $userTwo->phone,
            'email'                   =>  $userTwo->email,
            'products'                   =>  [
              0 =>  [
                'name'  =>  $this->product->name
              ]
            ]
          ]
        ])
      ->assertJsonStructureExact([
        'data'  =>  [
          'id',
          'name',
          'email',
          'email_verified_at',
          'active',
          'phone',
          'api_token',
          'created_at',
          'updated_at',
          'favourite_sub_product_id',
          'can_send_email',
          'products',
        ],
        'success'
      ]);
  }
}

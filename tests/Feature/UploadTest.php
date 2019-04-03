<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class UploadTest extends TestCase
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
  function user_must_be_logged_in_before_accessing_the_controller()
  {
    $this->json('post', '/api/upload_profile_image')
      ->assertStatus(401); 
  }

  /** @test */
  function it_requires_following_details()
  {
    $this->json('post', '/api/upload_profile_image', [], $this->headers)
      ->assertStatus(422)
      ->assertExactJson([
          "errors"  =>  [
            "user_id"       =>  ["The user id field is required."],
            "profile_image" =>  ["The profile image field is required."]
          ],
          "message" =>  "The given data was invalid."
        ]);
  }

  /** @test */
  function upload_profile_image_test()
  {
    Storage::fake('public');

    $payLoad = [
      'user_id'       =>  $this->user->id,
      'profile_image' => $profileImage = UploadedFile::fake()->image('random.jpg')
    ];

    $this->json('post', '/api/upload_profile_image', $payLoad, $this->headers)
      ->assertJson([
        'data'  => [
          'image_path'=> 'profileImages/' . $profileImage->hashName(),
        ]
      ]);

    $this->user->refresh();
    $this->assertEquals('profileImages/' . $profileImage->hashName(), $this->user->image_path);

    Storage::disk('public')->assertExists('profileImages/' . $profileImage->hashName());
  }

}

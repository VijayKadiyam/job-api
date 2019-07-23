<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SendEmailTest extends TestCase
{
  /** @test */
  function it_requires_role_name()
  {
    $payload = [
      'from_name'       =>  'From Name',
      'reply_to_email'  =>  'vijay@aaibuzz.com',
      'send_to_email'   =>  'kvjkumr@gmail.com',
      'sub_product_id'  =>  '1'
    ];
    $this->json('post', '/api/send_email', $payload);
  }
}

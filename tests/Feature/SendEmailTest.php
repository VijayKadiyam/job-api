<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SendEmailTest extends TestCase
{
  /** @test */
  function send_email()
  {
    $this->json('post', '/api/send_email', []);
  }
}

<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Facades\Schema;

class NotificationTest extends TestCase
{
    public function test_notification_has_expected_columns()
    {
        $this->assertTrue( 
            Schema::hasColumns('notifications', [
              'id','topic', 'message'
          ]), 1);
    }
}

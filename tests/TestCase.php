<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    // Laravel 12 discovers bootstrap/app.php through the base testing layer.
}

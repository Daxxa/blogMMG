<?php

namespace Tests\Unit;



use Tests\CreatesApplication;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Laravel\BrowserKitTesting\TestCase as BaseTestCase;


class ExampleTest extends BaseTestCase
{
    use CreatesApplication;
    public $baseUrl = 'http://localhost';
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBasicTest()
    {
        $this->visit('/')
            ->see('Categories');
    }


}

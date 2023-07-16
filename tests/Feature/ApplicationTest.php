<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ApplicationTest extends TestCase
{
	use RefreshDatabase;

	/**
	 * Seed the test DB with data
	 *
	 * @var bool
	 */
	protected bool $seed = false;

	/**
	 * A basic test example.
	 */
	public function test_the_application_returns_a_successful_response(): void
	{
		$response = $this->get('/');

		$response->assertStatus(200);
	}
}

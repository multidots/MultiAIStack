<?php
/**
 * Example unit test showing the Brain Monkey pattern.
 *
 * Delete this file once you have real tests — it exists so the very
 * first `composer test` run in a fresh project is green and so AI
 * agents have a concrete pattern to imitate.
 *
 * @package YourVendor\YourPlugin\Tests
 */

declare( strict_types=1 );

namespace YourVendor\YourPlugin\Tests\Unit;

use Brain\Monkey;
use Brain\Monkey\Functions;
use PHPUnit\Framework\TestCase;

/**
 * Demonstrates mocking WordPress functions in pure unit tests.
 */
final class ExampleServiceTest extends TestCase {

	/**
	 * Set up Brain Monkey before each test.
	 */
	protected function setUp(): void {
		parent::setUp();
		Monkey\setUp();
	}

	/**
	 * Tear down Brain Monkey after each test.
	 */
	protected function tearDown(): void {
		Monkey\tearDown();
		parent::tearDown();
	}

	/**
	 * A WordPress function can be stubbed with a fixed return value.
	 */
	public function test_wordpress_functions_can_be_stubbed(): void {
		Functions\when( 'sanitize_text_field' )->returnArg();
		Functions\when( 'absint' )->alias( static fn ( $value ) => abs( (int) $value ) );

		self::assertSame( 'hello', sanitize_text_field( 'hello' ) );
		self::assertSame( 42, absint( '-42' ) );
	}

	/**
	 * Expectations verify a hook or function was actually called.
	 */
	public function test_expectations_verify_calls(): void {
		Functions\expect( 'wp_cache_set' )
			->once()
			->with( 'example_key', 'value', 'example_group', 300 )
			->andReturn( true );

		// In a real test this call would live inside your service class.
		wp_cache_set( 'example_key', 'value', 'example_group', 300 );
	}
}

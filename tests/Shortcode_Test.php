<?php

namespace Syllables\Tests;

use WP_Mock\Tools\TestCase;
use Syllables;

/**
 * @coversDefaultClass \Syllables\Shortcode
 */
class Shortcode_Test extends TestCase {

	/**
	 * Shortcode object.
	 * @var Shortcode
	 */
	private $shortcode;

	/**
	 * Shortcode tag.
	 * @var string
	 */
	private $tag = 'test-shortcode';

	/**
	 * Shortcode callback.
	 * @var callable
	 */
	private $callback;

	/**
	 * Shortcode's output.
	 * @var string
	 */
	private $output = 'Test.';

	/**
	 * Setup a test method.
	 */
	public function setUp() {
		parent::setUp();

		$this->callback = function ( $atts ) {
			return $this->output;
		};

		$this->shortcode = new Syllables\Shortcode( $this->tag, $this->callback );
	}

	/**
	 * Clean up after a test method.
	 */
	public function tearDown() {
		parent::tearDown();

		$this->shortcode = null;
	}

	/**
	 * @covers ::add
	 */
	public function test_add() {

		\WP_Mock::wpFunction( 'shortcode_exists', array(
			'times'  => 1,
			'args'   => array( $this->tag ),
			'return' => false,
		) );

		\WP_Mock::wpFunction( 'add_shortcode', array(
			'times' => 1,
			'args'  => array( $this->tag, array( $this->shortcode, 'render' ) ),
		) );

		$this->shortcode->add();

		$this->assertConditionsMet();
	}

	/**
	 * @covers ::add
	 *
	 * @expectedException \Exception
	 */
	public function test_add_exists() {

		\WP_Mock::wpFunction( 'shortcode_exists', array(
			'times'  => 1,
			'args'   => array( $this->tag ),
			'return' => true,
		) );

		\WP_Mock::wpFunction( 'add_shortcode', array(
			'times' => 0,
		) );

		$this->shortcode->add();

		$this->assertConditionsMet();
	}

	/**
	 * @covers ::remove
	 */
	public function test_remove() {

		\WP_Mock::wpFunction( 'remove_shortcode', array(
			'times' => 1,
			'args'  => array( $this->tag ),
		) );

		$this->shortcode->remove();

		$this->assertConditionsMet();
	}

	/**
	 * @covers ::render
	 */
	public function test_render() {

		$this->markTestIncomplete();

		$atts = array( 'key' => 'value' );

		\WP_Mock::wpFunction( 'apply_filters', array(
			'times' => 1,
			'args'  => array( 'syllables/shortcode/render', $this->output, $atts, $this->tag ),
		) );

		$this->shortcode->render( $atts );

		// TODO: Fix failure.
		// TODO: Check that callback is called.

		$this->assertConditionsMet();
	}

}

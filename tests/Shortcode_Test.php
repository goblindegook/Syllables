<?php

namespace Syllables\Tests;

use WP_Mock\Tools\TestCase;

/**
 * @coversDefaultClass \Syllables\Shortcode
 */
class Shortcode_Test extends TestCase {

	/**
	 * Shortcode object.
	 * @var \Syllables\Shortcode
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
	 * Setup a test method.
	 */
	public function setUp() {
		parent::setUp();

		$this->callback = function ( $atts ) {
			return $atts['test'];
		};

		$this->shortcode = new \Syllables\Shortcode( $this->tag, $this->callback );
	}

	/**
	 * Clean up after a test method.
	 */
	public function tearDown() {
		parent::tearDown();

		$this->callback  = null;
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

		$this->assertConditionsMet( 'Add a shortcode hook.' );
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

		$this->assertConditionsMet( 'Throw an exception when re-adding a shortcode hook.' );
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

		$this->assertConditionsMet( 'Remove a shortcode hook.' );
	}

	/**
	 * @covers ::replace
	 */
	public function test_replace() {

		\WP_Mock::wpFunction( 'remove_shortcode', array(
			'times' => 1,
			'args'  => array( $this->tag ),
		) );

		\WP_Mock::wpFunction( 'shortcode_exists', array(
			'times'  => 1,
			'args'   => array( $this->tag ),
			'return' => false,
		) );

		\WP_Mock::wpFunction( 'add_shortcode', array(
			'times' => 1,
			'args'  => array( $this->tag, array( $this->shortcode, 'render' ) ),
		) );

		$this->shortcode->replace();

		$this->assertConditionsMet( 'Remove and re-add a shortcode hook.' );
	}

	/**
	 * @covers ::render
	 */
	public function test_render() {

		$atts = array( 'test' => 'expected' );

		$actual = $this->shortcode->render( $atts );

		$this->assertEquals( $actual, $atts['test'],
			'Shortcode renderer returns the callback output.' );

		\WP_Mock::onFilter( 'syllables/shortcode/render' )
			->with( $atts['test'], $atts, $this->tag )
			->reply( 'filtered' );

		$filtered = $this->shortcode->render( $atts );

		$this->assertEquals( $filtered, 'filtered',
			'Shortcode renderer filters the callback output.' );
	}

}

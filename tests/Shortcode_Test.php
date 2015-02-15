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

		$this->callback = function ( $atts, $content = '' ) {
			if ( ! empty( $content ) ) {
				return $atts['test'] . $content;
			}
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
	 * @covers ::get_tag
	 */
	public function test_get_tag() {
		$this->assertEquals( $this->shortcode->get_tag(), $this->tag,
			'Get the tag name.' );
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

		$expected_content = $atts['test'];
		$actual_content   = $this->shortcode->render( $atts );

		$this->assertEquals( $actual_content, $expected_content,
			'Shortcode renderer returns the callback output.' );

		$expected_content = $atts['test'] . 'test';
		$actual_content   = $this->shortcode->render( $atts, 'test' );

		$this->assertEquals( $actual_content, $expected_content,
			'Shortcode renderer returns the callback output with content.' );
	}

	/**
	 * @covers ::render
	 */
	public function test_render_filter() {
		$atts = array( 'test' => 'expected' );

		$unfiltered_content = $atts['test'] . 'test';
		$expected_content   = 'filtered';

		\WP_Mock::onFilter( 'syllables/shortcode/render' )
			->with( $unfiltered_content, $atts, $this->tag )
			->reply( $expected_content );

		$actual_content = $this->shortcode->render( $atts, 'test' );

		$this->assertEquals( $actual_content, $expected_content,
			'Shortcode renderer filters the callback output.' );
	}

}

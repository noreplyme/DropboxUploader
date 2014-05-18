<?php
/**
 * This file is part of Dropbox Uploader
 *
 * Phpunit test-suite
 */

/**
 * Class LoginTest
 */
class DropboxIntegrationTest extends BaseTestCase
{
    /**
     * @var DropboxUploader
     */
    private $subject;

    /**
     * Sets up the fixture, for example, open a network connection.
     * This method is called before a test is executed.
     *
     * @access protected
     */
    protected function setUp() {
        $this->subject = $this->createDefaultUploader();
    }

    /**
     * @test
     */
    public function testLoginAndUploadStringAsFile() {
        $uploader = $this->subject;

        list($usec, $sec) = explode(' ', microtime());
        $timestamp = date("r", $sec) . sprintf(" (%s Microseconds)", $usec * 1000000);
        $string    = 'This file is a test: ' . $timestamp . "\n";

        $this->addToAssertionCount(1);
        $uploader->uploadString($string, 'test.txt', 'test/integration');
    }

    /**
     * @test
     */
    public function testInvalidCertpathException() {
        $uploader = $this->subject;

        $thrown = FALSE;
        // provoke SSL error by using an existing but invalid certificate dir
        $uploader->setCaCertificateDir(dirname(__FILE__));

        try {
            $uploader->uploadString('fakse', 'fake.txt', 'test/integration');
        } catch (Exception $e) {
            $expected = "Curl error: (#60) SSL certificate problem";
            $this->assertStringStartsWith($expected, $e->getMessage());
            $thrown = TRUE;
        }
        $this->assertSame(TRUE, $thrown);
    }
}

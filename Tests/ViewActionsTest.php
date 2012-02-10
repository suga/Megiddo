<?php
require_once 'autoLoadTest.php';

/**
 * test case.
 */

class ViewActionsTest extends PHPUnit_Framework_TestCase {

    public function testReturnNone() {
        $this->assertContains('NONE', ViewActions::returnNone());
    }

    public function testReturnError() {
        $this->assertContains('ERROR', ViewActions::returnError());
    }

}


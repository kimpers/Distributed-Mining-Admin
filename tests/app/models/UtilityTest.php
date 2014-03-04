<?php

/**
 * Generated by PHPUnit_SkeletonGenerator 1.2.1 on 2014-03-04 at 15:32:15.
 */
class UtilityTest extends PHPUnit_Framework_TestCase {

    /**
     * @var Utility
     */

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp() {
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown() {
        
    }

    /**
     * @covers Utility::checkUser
     * @todo   Implement testCheckUser().
     */
    public function testCheckUser() {
        $user = new User("test_login", "password", 0);
        $login = Utility::checkUser($user->username, $user->password);
        $this->assertEquals(FALSE,$login);
        $user->persist();
        $login = Utility::checkUser($user->username, "wrong_password");
        $this->assertEquals(FALSE,$login);
        $login = Utility::checkUser($user->username, $user->password);
        $this->assertEquals(TRUE,$login);
        $user->delete();
    }

    /**
     * @covers Utility::readDbInfo
     * @todo   Implement testReadDbInfo().
     */
    public function testReadDbInfo() {
        $db_info = Utility::readDbInfo();
        $this->assertEquals(4, sizeof($db_info));
    }

}

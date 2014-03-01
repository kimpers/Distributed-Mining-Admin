<?php

/**
 * Generated by PHPUnit_SkeletonGenerator 1.2.1 on 2014-03-01 at 14:37:34.
 */
class MinerTest extends PHPUnit_Framework_TestCase {

    /**
     * @var Miner
     */
    protected $minerSocket;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp() {

        $this->minerSocket = new Miner('localhost', 4028);
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown() {
        $this->minerSocket = null;
    }


    /**
     * @covers Miner::request
     * @todo   Implement testRequest().
     */
    public function testRequest() {

        $res = $this->minerSocket->request('{"command":"version","parameter":""}');
        $this->assertEquals('4.0.0', $res['VERSION'][0]['SGMiner']);
        
    }


}

<?php

use App\URLHelper;
use PHPUnit\Framework\TestCase;

class URLHelperTest extends TestCase {

    public function testWithParam()
    {
        $url = URLHelper::withParam('p',  1, []);
        $this->assertEquals('p=1', $url);
    }

    public function testWithArrayParams()
    {
        $url = URLHelper::withParam('p',  [1,2,3], []);
        $url = urldecode($url);
        $this->assertEquals('p=1,2,3', $url);
    }

    public function testWithParams() {
        $url = URLHelper::withParams(['a' => 3], ['a' => 5, 'b' => 6]);
        $url = urldecode($url);
        $this->assertEquals('a=5&b=6', $url);
    }

    public function testWithParamsArray() {
        $url = URLHelper::withParams(['a' => 3], ['a' => [5,6], 'b' => 7]);
        $url = urldecode($url);
        $this->assertEquals('a=5,6&b=7', $url);
    }



}
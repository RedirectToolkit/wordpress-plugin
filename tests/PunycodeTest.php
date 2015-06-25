<?php
namespace Rdir\Wordpress\Plugin;

use True\Punycode;

class PunycodeTest extends \PHPUnit_Framework_TestCase
{
    private $puny;

    public function setUp()
    {
        $this->puny = new Punycode();
    }
}

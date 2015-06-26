<?php

namespace spec\Aplyca\BehatContext;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class URLContextSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Aplyca\BehatContext\URLContext');
    }
}

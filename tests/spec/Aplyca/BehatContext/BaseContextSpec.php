<?php

namespace spec\Aplyca\BehatContext;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class BaseContextSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Aplyca\BehatContext\BaseContext');
    }
}

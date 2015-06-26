<?php

namespace spec\Aplyca\BehatContext;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class FormContextSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Aplyca\BehatContext\FormContext');
    }
}

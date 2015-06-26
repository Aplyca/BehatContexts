<?php

namespace spec\Aplyca\BehatContext;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class SelectorsContextSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Aplyca\BehatContext\SelectorsContext');
    }

    function let()
    {
        $this->beConstructedWith('examples/selectors.yml');
    }

    function it_Can_use_Yaml_hash()
    {
        $this->beConstructedWith(array("feature" => array("item" => "value")));
        $this->Selectors->shouldBeArray();
    }
}

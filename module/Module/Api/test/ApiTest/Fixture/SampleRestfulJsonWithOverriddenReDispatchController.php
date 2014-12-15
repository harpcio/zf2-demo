<?php

namespace Module\ApiTest\Fixture;

class SampleRestfulJsonWithOverriddenReDispatchController extends SampleRestfulJsonController
{
    /**
     * @var SampleClass
     */
    protected $sample;

    public function __construct(SampleClass $sample)
    {
        $this->sample = $sample;
    }

    /**
     * We need to cover this method only for tests
     *
     * @param string $controller
     * @param array  $params
     *
     * @return array
     */
    protected function reDispatch($controller, array $params = [])
    {
        $this->sample->doSomething();

        $params['action'] = 'index';

        return [$controller . 'Controller', $params];
    }
}
<?php

/**
 * Class PipelineTest
 */
class PipelineTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function canProcessPipeline()
    {
        $pipeline = $this->_getPipeline();

        $pipeline->pipe(function ($argument) {
            return $argument * 100;
        });

        $this->assertEquals(1000, $pipeline->handle(1));
        $this->assertEquals(2000, $pipeline(2));
    }

    /**
     * Returns pipeline instance
     *
     * @return \Venta\Support\Pipeline
     */
    protected function _getPipeline()
    {
        return new \Venta\Support\Pipeline([function ($argument) {
            return $argument * 10;
        }]);
    }
}
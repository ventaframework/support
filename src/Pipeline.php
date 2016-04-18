<?php declare(strict_types = 1);

namespace Venta\Support;

use Ds\Vector;

/**
 * Class Pipeline
 *
 * @package Venta\Support
 */
class Pipeline
{
    /**
     * Collection of handlers
     *
     * @var Vector
     */
    protected $_handlers;

    /**
     * Construct function
     *
     * @param array $pipes
     */
    public function __construct(array $pipes = [])
    {
        $this->_handlers = new Vector;

        foreach ($pipes as $pipe) {
            $this->pipe($pipe);
        }
    }

    /**
     * Add handler to pipeline
     *
     * @param  callable $handler
     * @return $this
     */
    public function pipe(callable $handler)
    {
        $this->_handlers->push($handler);

        return $this;
    }

    /**
     * Execute pipeline
     *
     * @param  mixed $argument
     * @return $this
     */
    public function handle($argument)
    {
        foreach ($this->_handlers as $handler) {
            $argument = $handler($argument);
        }

        return $argument;
    }

    /**
     * Making object callable
     *
     * @param  null|mixed $argument
     * @return $this
     */
    public function __invoke($argument = null)
    {
        return $this->handle($argument);
    }
}
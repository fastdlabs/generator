<?php
/**
 * Created by PhpStorm.
 * User: janhuang
 * Date: 16/2/19
 * Time: 下午7:38
 * Github: https://www.github.com/janhuang
 * Coding: https://www.coding.net/janhuang
 * SegmentFault: http://segmentfault.com/u/janhuang
 * Blog: http://segmentfault.com/blog/janhuang
 * Gmail: bboyjanhuang@gmail.com
 * WebSite: http://www.janhuang.me
 */

namespace FastD\Generator\Factory;

/**
 * Class Object
 *
 * @package FastD\Generator\Factory
 */
class Object extends Generate
{
    /**
     * @var string
     */
    protected $namespace;

    /**
     * @var Property[]
     */
    protected $properties;

    /**
     * @var Method[]
     */
    protected $methods;

    protected $extends;

    public function __construct($name, $namespace = null, array $properties = [], array $methods = [])
    {
        $this->namespace = $namespace;

        $this->properties = $properties;

        $this->methods = $methods;

        foreach ($this->properties as $property) {
            $this->methods[] = new GetSetter($property->getName(), $property->getType());
        }

        parent::__construct($name, null, 'Class ' . $name);
    }

    public function generate()
    {
        $properties = [];

        foreach ($this->properties as $property) {
            $properties[] = $property->generate();
        }

        $properties = implode(PHP_EOL, $properties);

        $methods = [];

        foreach ($this->methods as $method) {
            $methods[] = $method->generate();
        }

        $methods = implode(PHP_EOL, $methods);

        return <<<M

class {$this->getName()}
{
{$properties}

{$methods}
}
M;
    }
}
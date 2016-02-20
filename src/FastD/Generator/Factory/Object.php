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
    const OBJECT_CLASS = 'class';
    const OBJECT_ABSTRACT = 'abstract class';
    const OBJECT_INTERFACE = 'interface';

    /**
     * @var string
     */
    protected $namespace;

    /**
     * @var Property[]
     */
    protected $properties = [];

    /**
     * @var Method[]
     */
    protected $methods = [];

    /**
     * @var self
     */
    protected $extend;

    /**
     * @var Interfaced[]
     */
    protected $interfaces = [];

    /**
     * Object constructor.
     * @param $name
     * @param null $namespace
     * @param string $type
     */
    public function __construct($name, $namespace = null, $type = self::OBJECT_CLASS)
    {
        $this->namespace = $namespace;

        parent::__construct($name, $type, 'Class ' . $name);
    }

    public function getNamespace()
    {
        return $this->namespace;
    }

    public function setExtends(self $object)
    {
        $this->extend = $object;

        return $this;
    }

    public function getExtends()
    {
        return null === $this->extend ? '' : ' extends ' . $this->extend->getName();
    }

    public function setImplements(array $interfaces)
    {
        $this->interfaces = $interfaces;

        return $this;
    }

    public function getImplements()
    {
        foreach ($this->interfaces as $interface) {
            $interface->getName();
        }
    }

    public function setProperties(array $properties)
    {
        $this->properties = $properties;

        return $this;
    }

    public function getProperties()
    {
        return $this->properties;
    }

    public function setMethods(array $methods)
    {
        $this->methods = $methods;

        return $this;
    }

    public function getMethods()
    {
        return $this->methods;
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

{$this->getType()} {$this->getName()}
{
    {$properties}

    {$methods}
}
M;
    }

    public function skeleton()
    {
        // TODO: Implement skeleton() method.
    }
}
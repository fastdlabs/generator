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
     * @var self[]
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

    /**
     * @return null|string
     */
    public function getNamespace()
    {
        return $this->namespace;
    }

    /**
     * @param Object $object
     * @return $this
     */
    public function setExtends(self $object)
    {
        $this->extend = $object;

        return $this;
    }

    /**
     * @return string
     */
    public function getExtends()
    {
        return null === $this->extend ? '' : ' extends ' . str_replace('\\\\', '\\', implode('\\', [$this->extend->getNamespace(), $this->extend->getName()]));
    }

    /**
     * @param array $interfaces
     * @return $this
     */
    public function setImplements(array $interfaces)
    {
        $this->interfaces = $interfaces;

        return $this;
    }

    /**
     * @return Object[]
     */
    public function getImplements()
    {
        return $this->interfaces;
    }

    /**
     * @param array $properties
     * @return $this
     */
    public function setProperties(array $properties)
    {
        $this->properties = $properties;

        return $this;
    }

    /**
     * @return Property[]
     */
    public function getProperties()
    {
        return $this->properties;
    }

    /**
     * @param array $methods
     * @return $this
     */
    public function setMethods(array $methods)
    {
        $this->methods = $methods;

        return $this;
    }

    /**
     * @return Method[]
     */
    public function getMethods()
    {
        return $this->methods;
    }

    /**
     * @return string
     */
    public function generate()
    {
        $properties = [];

        foreach ($this->properties as $property) {
            $properties[] = $property->generate();
        }

        $properties = implode(PHP_EOL, $properties);

        $interfaces = [];

        foreach ($this->interfaces as $interface) {
            $interfaces[] = str_replace('\\\\', '\\', implode('\\', [$interface->getNamespace(), $interface->getName()]));
        }

        if (!empty($interfaces)) {
            $interfaces = 'implements ' . implode(',', $interfaces);
        }

        $methods = [];

        foreach ($this->methods as $method) {
            $methods[] = $method->generate();
        }

        $methods = implode(PHP_EOL, $methods);

        return <<<M

{$this->getType()} {$this->getName()} {$this->getExtends()} {$interfaces}
{
    {$properties}

    {$methods}
}
M;
    }

    /**
     * @return string
     */
    public function skeleton()
    {
        return $this->generate();
    }
}
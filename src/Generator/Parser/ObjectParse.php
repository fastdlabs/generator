<?php
/**
 * Created by PhpStorm.
 * User: janhuang
 * Date: 16/2/21
 * Time: 上午12:04
 * Github: https://www.github.com/janhuang
 * Coding: https://www.coding.net/janhuang
 * SegmentFault: http://segmentfault.com/u/janhuang
 * Blog: http://segmentfault.com/blog/janhuang
 * Gmail: bboyjanhuang@gmail.com
 * WebSite: http://www.janhuang.me
 */

namespace FastD\Generator\Parser;

use FastD\Generator\Factory\Object;

/**
 * Class ObjectParse
 *
 * @package FastD\Generator\Parser
 */
class ObjectParse extends Parser implements ParserInterface
{
    /**
     * @var \ReflectionClass
     */
    protected $reflector;

    /**
     * ObjectParse constructor.
     * @param mixed $class
     */
    public function __construct($class)
    {
        parent::__construct(new \ReflectionClass($class));

        $file = new \SplFileObject($this->reflector->getFileName());

        $usages = [];

        $i = 1;
        $end = $this->reflector->getStartLine();
        $file->seek($i);
        while ($i < $end) {
            $line = $file->current();
            if ('use' === substr($line, 0, 3)) {
                $usages[] = substr($line, 4, -2);
            }
            $file->next();
            $i++;
        }
        unset($file);

        $this->factory = new Object($this->reflector->getShortName(), $this->reflector->getNamespaceName());
        $this->factory->setUsages($usages);

        $properties = [];

        foreach ($this->reflector->getConstants() as $name => $value) {
            $properties[$name] = (new ConstantParser($name, $value))->getGenerator();
        }

        foreach ($this->reflector->getProperties() as $property) {
            if ($property->getDeclaringClass()->getName() !== $this->reflector->getName()) {
                continue;
            }
            $properties[$property->getName()] = (new PropertyParser($this->reflector, $property->getName()))->getGenerator();
        }

        $methods = [];
        foreach ($this->reflector->getMethods() as $method) {
            if ($method->getDeclaringClass()->getName() !== $this->reflector->getName()) {
                continue;
            }
            $methods[$method->getName()] = (new MethodParser($method))->getGenerator();
        }

        $this->factory->setProperties($properties);
        $this->factory->setMethods($methods);

        $interfaces = [];
        foreach ($this->reflector->getInterfaces() as $interface) {
            $interfaces[$interface->getShortName()] = new Object($interface->getShortName(), $interface->getNamespaceName(), Object::OBJECT_INTERFACE);
        }
        $this->factory->setImplements($interfaces);

        if (false !== ($parent = $this->reflector->getParentClass())) {
            $this->factory->setExtends(new Object($parent->getShortName(), $parent->getNamespaceName(), Object::OBJECT_CLASS));
        }
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: janhuang
 * Date: 16/2/21
 * Time: 下午11:34
 * Github: https://www.github.com/janhuang
 * Coding: https://www.coding.net/janhuang
 * SegmentFault: http://segmentfault.com/u/janhuang
 * Blog: http://segmentfault.com/blog/janhuang
 * Gmail: bboyjanhuang@gmail.com
 * WebSite: http://www.janhuang.me
 */

namespace FastD\Generator\Parser;

use FastD\Generator\Factory\Property;

/**
 * Class PropertyParser
 *
 * @package FastD\Generator\Parser
 */
class PropertyParser extends Parser implements ParserInterface
{
    /**
     * @var \ReflectionProperty
     */
    protected $reflector;

    /**
     * PropertyParser constructor.
     * @param \ReflectionClass $reflectionClass
     * @param $name
     */
    public function __construct(\ReflectionClass $reflectionClass, $name)
    {
        $property = $reflectionClass->getProperty($name);

        parent::__construct($property);

        $property->setAccessible(true);

        if ($property->isPrivate()) {
            $accessible = Property::PROPERTY_ACCESS_PRIVATE;
        } else if ($property->isProtected()) {
            $accessible = Property::PROPERTY_ACCESS_PROTECTED;
        } else {
            $accessible = Property::PROPERTY_ACCESS_PUBLIC;
        }

        $this->factory = new Property($property->getName(), $accessible);

        $this->factory->setValue($property->getValue($reflectionClass->newInstanceWithoutConstructor()));

        if ($this->reflector->isStatic()) {
            $this->factory->setStatic();
        }
    }
}
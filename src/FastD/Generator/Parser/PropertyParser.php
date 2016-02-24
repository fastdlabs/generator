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

class PropertyParser extends Parser implements ParserInterface
{
    /**
     * @var \ReflectionProperty
     */
    protected $reflector;

    protected $name;

    protected $value;

    protected $accessible;

    public function __construct(\ReflectionClass $reflectionClass, $name)
    {
        $property = $reflectionClass->getProperty($name);

        parent::__construct($property);

        $this->name = $property->getName();

        $property->setAccessible(true);

        $this->value = $property->getValue($reflectionClass->newInstanceWithoutConstructor());

        if ($property->isPrivate()) {
            $this->accessible = 'private';
        } else if ($property->isProtected()) {
            $this->accessible = 'protected';
        } else {
            $this->accessible = 'public';
        }
    }

    public function getName()
    {
        return $this->name;
    }

    public function getValue()
    {
        return $this->value;
    }

    /**
     * @return string
     */
    public function getContent()
    {
        $value = $this->getValue();

        if (empty($value)) {
            $value = '';
        } else if (is_string($value)) {
            $value = ' = \'' . $value . '\'';
        } else {
            $value = ' = ' . $value;
        }

        $static = $this->reflector->isStatic() ? ' static ' : '';

        return <<<P
    {$this->accessible}{$static} \${$this->name}{$value};
P;
    }
}
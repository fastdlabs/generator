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
     * @var MethodParser[]
     */
    protected $methods = [];

    /**
     * @var PropertyParser[]
     */
    protected $properties = [];

    /**
     * @var ConstantParser[]
     */
    protected $constants = [];

    /**
     * @var array
     */
    protected $namespaces = [];

    /**
     * ObjectParse constructor.
     * @param mixed $class
     */
    public function __construct($class)
    {
        parent::__construct(new \ReflectionClass($class));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->reflector->getShortName();
    }

    /**
     * @return string
     */
    public function getNamespace()
    {
        return $this->reflector->getNamespaceName();
    }

    /**
     * @return \ReflectionClass
     */
    public function getParent()
    {
        return $this->reflector->getParentClass();
    }

    /**
     * @return array
     */
    public function getImplements()
    {
        return $this->reflector->getInterfaceNames();
    }

    /**
     * @param $name
     * @return MethodParser
     */
    public function getMethod($name)
    {
        return new MethodParser($this->reflector->getMethod($name));
    }

    /**
     * @return MethodParser[]
     */
    public function getMethods()
    {
        if (empty($this->methods)) {
            foreach ($this->reflector->getMethods() as $method) {
                $this->methods[] = new MethodParser($method);
            }
        }

        return $this->methods;
    }

    /**
     * @param $name
     * @return PropertyParser
     */
    public function getProperty($name)
    {
        return new PropertyParser($this->reflector, $name);
    }

    /**
     * @return PropertyParser[]
     */
    public function getProperties()
    {
        if (empty($this->properties)) {
            foreach ($this->reflector->getProperties() as $property) {
                $this->properties[] = new PropertyParser($this->reflector, $property->getName());
            }
        }

        return $this->properties;
    }

    /**
     * @param $name
     * @return ConstantParser
     */
    public function getConstant($name)
    {
        return new ConstantParser($name, $this->reflector->getConstant($name));
    }

    /**
     * @return ConstantParser[]
     */
    public function getConstants()
    {
        if (empty($this->constants)) {
            foreach ($this->reflector->getConstants() as $name => $value) {
                $this->constants[] = new ConstantParser($name, $value);
            }
        }

        return $this->constants;
    }

    /**
     * @return string
     */
    public function getContent()
    {
        $constants = [];

        foreach ($this->getConstants() as $constant) {
            $constants[] = $constant->getContent();
        }

        $constants = implode(PHP_EOL, $constants);

        $properties = [];

        foreach ($this->getProperties() as $property) {
            $properties[] = $property->getContent();
        }

        $properties = implode(PHP_EOL, $properties);

        $methods = [];

        foreach ($this->getMethods() as $method) {
            $methods[] = $method->getContent();
        }

        $methods = implode(PHP_EOL, $methods);

        $namespace = empty($this->getNamespace()) ? '' : 'namespace ' . $this->getNamespace() . ';' . PHP_EOL;

        $parent = '';

        if ($this->getParent()) {
            $parent = ' extends ' . '\\' . $this->getParent()->getName();
        }

        $interfaces = [];

        foreach ($this->getImplements() as $implement) {
            $interfaces[] = '\\' . $implement;
        }

        if (!empty($interfaces)) {
            $interfaces = ' implements ' . implode(', ', $interfaces);
        } else {
            $interfaces = '';
        }

        $classType = $this->reflector->isAbstract() ? 'abstract class' : 'class';

        $file = new \SplFileObject($this->reflector->getFileName());

        $usages = [];

        $i = 1;
        $end = $this->reflector->getStartLine();
        $file->seek($i);
        while ($i < $end) {
            $line = $file->current();
            if ('use' === substr($line, 0, 3)) {
                $usages[] = $line;
            }
            $file->next();
            $i++;
        }
        unset($file);

        if (!empty($usages)) {
            $usages = implode(PHP_EOL, $usages);
        } else {
            $usages = '';
        }

        return <<<C
{$namespace}
{$usages}
{$classType} {$this->getName()}{$parent}{$interfaces}
{
{$constants}
{$properties}
{$methods}
}
C;
    }
}
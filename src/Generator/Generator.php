<?php
/**
 * Created by PhpStorm.
 * User: janhuang
 * Date: 15/10/11
 * Time: 上午1:13
 * Github: https://www.github.com/janhuang
 * Coding: https://www.coding.net/janhuang
 * SegmentFault: http://segmentfault.com/u/janhuang
 * Blog: http://segmentfault.com/blog/janhuang
 * Gmail: bboyjanhuang@gmail.com
 * WebSite: http://www.janhuang.me
 */

namespace FastD\Generator;

use FastD\Generator\Factory\Method;
use FastD\Generator\Factory\Property;
use FastD\Generator\Parser\ObjectParse;
use FastD\Generator\Factory\Object;

/**
 * Class Generator
 *
 * @package FastD\Generator
 */
class Generator implements GeneratorInterface
{
    /**
     * @var Object|Object
     */
    protected $object;

    /**
     * Generator constructor.
     * @param $name
     * @param null $namespace
     * @param string $type
     */
    public function __construct($name, $namespace = null, $type = Object::OBJECT_CLASS)
    {
        $shortName = $name;

        try {
            if (!empty($namespace)) {
                $name = $namespace . '\\' . $name;
            }
            $this->object = (new ObjectParse($name))->getGenerator();
        } catch (\Exception $e) {
            $this->object = new Object($shortName, $namespace, $type);
        }
    }

    /**
     * @param bool $output
     * @return string|int
     */
    public function output($output = true)
    {
        if (!$output) {
            return $this->object->generate();
        }

        echo $this->object->generate();

        return 0;
    }

    /**
     * @param null|string $file
     * @return int
     */
    public function save($file)
    {
        if (!file_exists(dirname($file))) {
            mkdir(dirname($file), 0755, true);
        }

        return file_put_contents($file, '<?php' . PHP_EOL . $this->output(false));
    }

    /**
     * @return string
     */
    public function getNamespace()
    {
        return $this->object->getNamespace();
    }

    /**
     * @param array Property[] $properties
     * @param bool $flag
     * @return GeneratorInterface
     */
    public function setProperties(array $properties, $flag = false)
    {
        if (!$flag) {
            $this->object->appendProperties($properties);
        } else {
            $this->object->setProperties($properties);
        }

        return $this;
    }

    /**
     * @return Property[]
     */
    public function getProperties()
    {
        return $this->object->getProperties();
    }

    /**
     * @param array Method[] $methods
     * @param bool $flag
     * @return GeneratorInterface
     */
    public function setMethods(array $methods, $flag = false)
    {
        if (!$flag) {
            $this->object->appendMethods($methods);
        } else {
            $this->object->setMethods($methods);
        }

        return $this;
    }

    /**
     * @return Method[]
     */
    public function getMethods()
    {
        return $this->object->getMethods();
    }

    /**
     * @param Object $object
     * @return $this
     */
    public function setExtends(Object $object)
    {
        $this->object->setExtends($object);

        return $this;
    }

    /**
     * @return Object
     */
    public function getExtends()
    {
        return $this->object->getExtends();
    }

    /**
     * @return Object|Object
     */
    public function getObject()
    {
        return $this->object;
    }
}
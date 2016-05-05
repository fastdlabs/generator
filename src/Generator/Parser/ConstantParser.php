<?php
/**
 * Created by PhpStorm.
 * User: janhuang
 * Date: 16/2/24
 * Time: 上午11:43
 * Github: https://www.github.com/janhuang
 * Coding: https://www.coding.net/janhuang
 * SegmentFault: http://segmentfault.com/u/janhuang
 * Blog: http://segmentfault.com/blog/janhuang
 * Gmail: bboyjanhuang@gmail.com
 * WebSite: http://www.janhuang.me
 */

namespace FastD\Generator\Parser;

use FastD\Generator\Factory\Generate;
use FastD\Generator\Factory\Property;

/**
 * Class ConstantParser
 *
 * @package FastD\Generator\Parser
 */
class ConstantParser implements ParserInterface
{
    /**
     * @var Property
     */
    protected $factory;

    /**
     * ConstantParser constructor.
     * @param $name
     * @param $value
     */
    public function __construct($name, $value)
    {
        $this->factory = new Property($name, Property::PROPERTY_CONST);

        $this->factory->setValue($value);
    }

    /**
     * @return string
     */
    public function getContent()
    {
        return $this->factory->generate();
    }

    /**
     * @return Generate
     */
    public function getGenerator()
    {
        return $this->factory;
    }
}
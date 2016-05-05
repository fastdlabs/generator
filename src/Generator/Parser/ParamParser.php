<?php
/**
 * Created by PhpStorm.
 * User: janhuang
 * Date: 16/2/24
 * Time: 下午2:07
 * Github: https://www.github.com/janhuang
 * Coding: https://www.coding.net/janhuang
 * SegmentFault: http://segmentfault.com/u/janhuang
 * Blog: http://segmentfault.com/blog/janhuang
 * Gmail: bboyjanhuang@gmail.com
 * WebSite: http://www.janhuang.me
 */

namespace FastD\Generator\Parser;
use FastD\Generator\Factory\Param;

/**
 * Class ParamParser
 *
 * @package FastD\Generator\Parser
 */
class ParamParser extends Parser implements ParserInterface
{
    /**
     * @var \ReflectionParameter
     */
    protected $reflector;

    /**
     * ParamParser constructor.
     * @param \ReflectionParameter $reflector
     */
    public function __construct(\ReflectionParameter $reflector)
    {
        parent::__construct($reflector);

        $name = $reflector->getName();
        $class = '';

        if ($reflector->getClass()) {
            $class = $reflector->getClass()->getName();
        }

        if ($reflector->isDefaultValueAvailable()) {
            if ($reflector->isDefaultValueConstant()) {
                $value = $reflector->getDefaultValueConstantName();
            } else {
                $value = $reflector->getDefaultValue();
            }
        } else {
            $value = Param::PARAM_NONE;
        }

        $this->factory = new Param($name, $class, $value);
    }
}
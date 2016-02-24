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
     * @var string
     */
    protected $class;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $value;

    /**
     * ParamParser constructor.
     * @param \ReflectionParameter $reflector
     */
    public function __construct(\ReflectionParameter $reflector)
    {
        parent::__construct($reflector);

        $this->name = $reflector->getName();

        if ($reflector->getClass()) {
            $this->class = $reflector->getClass()->getName() . ' ';
        }

        if ($reflector->isDefaultValueAvailable()) {
            if ($reflector->isDefaultValueConstant()) {
                $this->value = ' = ' . $reflector->getDefaultValueConstantName();
            } else {
                if (null === $reflector->getDefaultValue()) {
                    $this->value = ' = null';
                } else {
                    $value = $reflector->getDefaultValue();
                    if (is_integer($value)) {
                        $this->value = ' = ' . $value;
                    } else {
                        $this->value = ' = \'' . $value . '\'';
                    }
                }
            }
        }
    }

    /**
     * @return string
     */
    public function getContent()
    {
        return $this->class . '$' . $this->name . $this->value;
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: janhuang
 * Date: 16/2/29
 * Time: 下午12:21
 * Github: https://www.github.com/janhuang
 * Coding: https://www.coding.net/janhuang
 * SegmentFault: http://segmentfault.com/u/janhuang
 * Blog: http://segmentfault.com/blog/janhuang
 * Gmail: bboyjanhuang@gmail.com
 * WebSite: http://www.janhuang.me
 */

namespace FastD\Generator\Factory;

/**
 * Class Param
 *
 * @package FastD\Generator\Factory
 */
class Param extends Generate
{
    const PARAM_NONE = 1;

    /**
     * @var string
     */
    protected $class;

    protected $default;

    /**
     * Param constructor.
     * @param $name
     * @param string $class
     * @param string|int $value
     * @param string $type
     * @param string $desc
     */
    public function __construct($name, $class = '', $value = self::PARAM_NONE, $type = 'mixed', $desc = '')
    {
        parent::__construct($name, $type, $desc);

        $this->class = $class;

        $this->default = $value;
    }

    /**
     * @return string
     */
    public function generate()
    {
        return $this->skeleton();
    }

    /**
     * @return string
     */
    public function skeleton()
    {
        $class = '';
        if (!empty($this->class)) {
            $class = '\\' . $this->class . ' ';
        }

        $default = '';

        if (self::PARAM_NONE !== $this->default) {
            if (is_string($this->default)) {
                $default = '\'' . $this->default . '\'';
            } else if (null === $this->default) {
                $default = 'null';
            } else {
                $default = $this->default;
            }

            $default = ' = ' . $default;
        }

        return $class . '$' . $this->getName() . $default;
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: janhuang
 * Date: 16/2/19
 * Time: 下午6:06
 * Github: https://www.github.com/janhuang
 * Coding: https://www.coding.net/janhuang
 * SegmentFault: http://segmentfault.com/u/janhuang
 * Blog: http://segmentfault.com/blog/janhuang
 * Gmail: bboyjanhuang@gmail.com
 * WebSite: http://www.janhuang.me
 */

namespace FastD\Generator\Factory;

/**
 * Class Generate
 *
 * @package FastD\Generator\Factory
 */
abstract class Generate
{
    /**
     * @var
     */
    protected $name;

    /**
     * @var string
     */
    protected $type;

    /**
     * @var string
     */
    protected $desc;

    /**
     * Generate constructor.
     * @param $name
     * @param string $type
     * @param string $desc
     */
    public function __construct($name, $type = 'mixed', $desc = '')
    {
        if (null !== $name) {

        }
        $this->name = $name;

        $this->type = $type;

        $this->desc = $desc;
    }

    /**
     * @return string
     */
    public function getDesc()
    {
        return $this->desc;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    abstract public function generate();

    /**
     * @return string
     */
    abstract public function skeleton();

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->generate();
    }
}
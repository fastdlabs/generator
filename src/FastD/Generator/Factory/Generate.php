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

    public function getDesc()
    {
        return $this->desc;
    }

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

    abstract public function generate();

    abstract public function skeleton();
}
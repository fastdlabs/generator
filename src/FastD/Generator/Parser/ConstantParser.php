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

/**
 * Class ConstantParser
 *
 * @package FastD\Generator\Parser
 */
class ConstantParser implements ParserInterface
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var string|int
     */
    protected $value;

    /**
     * ConstantParser constructor.
     * @param $name
     * @param $value
     */
    public function __construct($name, $value)
    {
        $this->name = $name;

        $this->value = $value;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return int|string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @return string
     */
    public function getContent()
    {
        $value = (is_integer($this->value) ? $this->value : '\'' . $this->value . '\'');
        return <<<M
    const {$this->name} = $value;
M;

    }
}
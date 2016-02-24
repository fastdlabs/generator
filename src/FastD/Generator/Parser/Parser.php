<?php
/**
 * Created by PhpStorm.
 * User: janhuang
 * Date: 16/2/22
 * Time: 下午10:53
 * Github: https://www.github.com/janhuang
 * Coding: https://www.coding.net/janhuang
 * SegmentFault: http://segmentfault.com/u/janhuang
 * Blog: http://segmentfault.com/blog/janhuang
 * Gmail: bboyjanhuang@gmail.com
 * WebSite: http://www.janhuang.me
 */

namespace FastD\Generator\Parser;

/**
 * Class Parser
 *
 * @package FastD\Generator\Parser
 */
abstract class Parser implements ParserInterface
{
    /**
     * @var \Reflector
     */
    protected $reflector;

    /**
     * Parser constructor.
     * @param \Reflector $reflector
     */
    public function __construct(\Reflector $reflector)
    {
        $this->reflector = $reflector;
    }

    /**
     * @param $name
     * @return mixed|string
     */
    public function parseName($name)
    {
        if (strpos($name, '_')) {
            $arr = explode('_', $name);
            $name = array_shift($arr);
            foreach ($arr as $value) {
                $name .= ucfirst($value);
            }
        }

        return $name;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getContent();
    }
}
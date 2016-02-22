<?php
/**
 * Created by PhpStorm.
 * User: janhuang
 * Date: 16/2/21
 * Time: 下午11:35
 * Github: https://www.github.com/janhuang
 * Coding: https://www.coding.net/janhuang
 * SegmentFault: http://segmentfault.com/u/janhuang
 * Blog: http://segmentfault.com/blog/janhuang
 * Gmail: bboyjanhuang@gmail.com
 * WebSite: http://www.janhuang.me
 */

namespace FastD\Generator\Parser;

class MethodParser implements ParserInterface
{
    protected $method;

    protected $content;

    public function __construct(\ReflectionMethod $method)
    {
        $this->method = $method;
    }

    public function getName()
    {
        return $this->method->getName();
    }

    public function getParameters()
    {
        return $this->method->getParameters();
    }

    /**
     * @return string
     */
    public function getContent()
    {

    }
}
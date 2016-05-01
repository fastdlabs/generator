<?php
/**
 * Created by PhpStorm.
 * User: janhuang
 * Date: 16/2/19
 * Time: 下午5:03
 * Github: https://www.github.com/janhuang
 * Coding: https://www.coding.net/janhuang
 * SegmentFault: http://segmentfault.com/u/janhuang
 * Blog: http://segmentfault.com/blog/janhuang
 * Gmail: bboyjanhuang@gmail.com
 * WebSite: http://www.janhuang.me
 */

namespace FastD\Generator;

interface CombinationInterface
{
    public function appendClass($class);

    public function combination(array $classes);
}
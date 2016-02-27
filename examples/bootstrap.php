<?php
/**
 * Created by PhpStorm.
 * User: janhuang
 * Date: 16/2/27
 * Time: 下午12:33
 * Github: https://www.github.com/janhuang
 * Coding: https://www.coding.net/janhuang
 * SegmentFault: http://segmentfault.com/u/janhuang
 * Blog: http://segmentfault.com/blog/janhuang
 * Gmail: bboyjanhuang@gmail.com
 * WebSite: http://www.janhuang.me
 */

$loader = include __DIR__.'/../vendor/autoload.php';
// /Users/janhuang/Documents/htdocs/me/fastd/library/generator/src/FastD/Generator/Tests/Output/Test5.php
$loader->addPsr4('Test\\', __DIR__ . '/../src/FastD/Generator/Tests/Output');

return $loader;

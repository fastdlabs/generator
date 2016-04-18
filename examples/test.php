<?php
/**
 * Created by PhpStorm.
 * User: janhuang
 * Date: 16/4/18
 * Time: 下午10:23
 * Github: https://www.github.com/janhuang
 * Coding: https://www.coding.net/janhuang
 * SegmentFault: http://segmentfault.com/u/janhuang
 * Blog: http://segmentfault.com/blog/janhuang
 * Gmail: bboyjanhuang@gmail.com
 * WebSite: http://www.janhuang.me
 */

include __DIR__ . '/../vendor/autoload.php';

$generator = new \FastD\Generator\Generator('Test');

echo $generator->output();

$generator->save(__DIR__ . '/save/Test.php');
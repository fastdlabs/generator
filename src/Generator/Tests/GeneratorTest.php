<?php
/**
 * Created by PhpStorm.
 * User: janhuang
 * Date: 16/2/19
 * Time: 下午5:58
 * Github: https://www.github.com/janhuang
 * Coding: https://www.coding.net/janhuang
 * SegmentFault: http://segmentfault.com/u/janhuang
 * Blog: http://segmentfault.com/blog/janhuang
 * Gmail: bboyjanhuang@gmail.com
 * WebSite: http://www.janhuang.me
 */

namespace FastD\Generator;

use FastD\Generator\Factory\GetSetter;
use FastD\Generator\Factory\Method;
use FastD\Generator\Factory\Object;
use FastD\Generator\Factory\Property;

class GeneratorTest extends \PHPUnit_Framework_TestCase
{
    public function testBase()
    {
        $generator = new Generator('Test2', "Test");

        $generator->setMethods([
            'test2' => new Method('test2'),
        ]);

        $this->assertEquals(<<<M

namespace Test;

use FastD\Generator\Generator;

class Test2 extends \Test\Test implements \Test\TestInterface
{
    /**
     * @const mixed
     */
    const TESET = 'abc';

    /**
     * @var mixed
     */
    protected \$name;

    /**
     * @var mixed
     */
    protected \$default = 'jan';

    /**
     * @var mixed
     */
    protected static \$age = 18;

    public function test(\FastD\Generator\Generator \$generator, \$name = 'test', \$test = 'self::TESET', \$four = 11)
    {
        // TODO...
    }

    public function test2()
    {
        // TODO...
    }
}
M
, $generator->output(false));
    }
}

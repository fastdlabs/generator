<?php
/**
 * Created by PhpStorm.
 * User: janhuang
 * Date: 15/10/11
 * Time: 上午1:13
 * Github: https://www.github.com/janhuang
 * Coding: https://www.coding.net/janhuang
 * SegmentFault: http://segmentfault.com/u/janhuang
 * Blog: http://segmentfault.com/blog/janhuang
 * Gmail: bboyjanhuang@gmail.com
 * WebSite: http://www.janhuang.me
 */

namespace FastD\Generator;

use FastD\Generator\Parser\Parser;
use FastD\Generator\Parser\ObjectParse;
use FastD\Generator\Factory\Object;

/**
 * Class Generator
 *
 * @package FastD\Generator
 */
class Generator extends Object implements GeneratorInterface
{
    /**
     * @var string
     */
    protected $file;

    protected $parser;

    /**
     * Generator constructor.
     * @param $file
     * @param null $namespace
     * @param string $type
     */
    public function __construct($file, $namespace = null, $type = Object::OBJECT_CLASS)
    {
        $this->file = $file;

        $name = ucfirst(pathinfo($file, PATHINFO_FILENAME));

        parent::__construct($name, $namespace, $type);
    }

    /**
     * @return string
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * @return string
     */
    public function getClassName()
    {
        return parent::getName();
    }

    /**
     * @param bool $output
     * @return string|int
     */
    public function output($output = true)
    {
        $str = $this->generate();

        if (!$output) {
            return $str;
        }

        echo $str;
    }

    /**
     * @param null|string $file
     * @return int
     */
    public function save($file = null)
    {
        return file_put_contents($file ?? $this->file, '<?php' . PHP_EOL . $this->output(false));
    }

    /**
     * @return Parser
     */
    public function getParser()
    {
        return new ObjectParse($this);
    }
}
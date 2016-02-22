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
    protected $parser;

    public function __construct($name, $namespace = null, $type = null)
    {
        try {
            $this->parser = new ObjectParse($name);
        } catch (\Exception $e) {}

        parent::__construct($name, $namespace, $type);
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
    public function save($file)
    {
        return file_put_contents($file, '<?php' . PHP_EOL . $this->output(false));
    }

    /**
     * @return mixed
     */
    public function getParser()
    {
        return $this->parser;
    }
}
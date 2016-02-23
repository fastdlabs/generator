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

/**
 * Class MethodParser
 *
 * @package FastD\Generator\Parser
 */
class MethodParser extends Parser implements ParserInterface
{
    /**
     * @var string
     */
    protected $content;

    /**
     * @return string
     */
    public function getName()
    {
        return $this->reflector->getName();
    }

    /**
     * @return \ReflectionParameter[]
     */
    public function getParameters()
    {
        return $this->reflector->getParameters();
    }

    /**
     * @return string
     */
    public function getContent()
    {
        $i = 0;
        $startLine = $this->reflector->getStartLine() - 1;
        $length = $this->reflector->getEndLine() - $startLine;
        $file = new \SplFileObject($this->reflector->getFileName());
        $file->seek($startLine);
        $content = '';
        while ($i < $length) {
            $content .= $file->current();
            $file->next();
            $i++;
        }
        $doc = '';
        if ($this->reflector->getDocComment()) {
            $doc = $this->reflector->getDocComment() . PHP_EOL;
        }
        return $doc . $content;
    }
}
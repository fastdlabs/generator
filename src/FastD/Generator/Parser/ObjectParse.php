<?php
/**
 * Created by PhpStorm.
 * User: janhuang
 * Date: 16/2/21
 * Time: 上午12:04
 * Github: https://www.github.com/janhuang
 * Coding: https://www.coding.net/janhuang
 * SegmentFault: http://segmentfault.com/u/janhuang
 * Blog: http://segmentfault.com/blog/janhuang
 * Gmail: bboyjanhuang@gmail.com
 * WebSite: http://www.janhuang.me
 */

namespace FastD\Generator\Parser;

class ObjectParse extends \ReflectionClass implements ParserInterface
{
    protected $content = '';

    public function getUsageNamespace()
    {

    }

    /**
     * @param $name
     * @return string
     */
    public function getContent($name = null)
    {
        if (!empty($this->content)) {
            return $this->content;
        }

        $file = new \SplFileObject($this->getFileName());

        $start = $this->getStartLine() - 1 - substr_count($this->getDocComment(), PHP_EOL) - 1;

        $i = 1;$length = $this->getEndLine() - $start + 2;

        $file->seek($start);

        while ($i < $length) {
            $this->content .= $file->current();
            $file->next();
            $i++;
        }

        $namespace = $this->getNamespaceName() ? 'namespace ' . $this->getNamespaceName() . PHP_EOL : '';

        $this->content = $namespace . $this->content;

        return $this->content;
    }
}
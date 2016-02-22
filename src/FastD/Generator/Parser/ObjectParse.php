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

/**
 * Class ObjectParse
 *
 * @package FastD\Generator\Parser
 */
class ObjectParse extends \ReflectionClass implements ParserInterface
{
    /**
     * @var int
     */
    protected $startLine = 1;

    /**
     * @var string
     */
    protected $content;

    /**
     * @var array
     */
    protected $namespaces = [];

    /**
     * ObjectParse constructor.
     * @param mixed $argument
     */
    public function __construct($argument)
    {
        parent::__construct($argument);

        $this->parseContent();
    }

    /**
     * @return int
     */
    public function getStartLine()
    {
        return $this->startLine;
    }

    /**
     * @return string
     */
    protected function parseContent()
    {
        if (empty($this->content)) {
            $file = new \SplFileObject($this->getFileName());
            // Get file content and parse namespace and use.
            $i = 1;
            while (!$file->eof()) {
                $line = $file->fgets();
                // The class namespace start line.
                if ('namespace' == substr($line, 0, 9)) {
                    $this->startLine = $i;
                }
                // The class use classes.
                if ('use' == substr($line, 0, 3)) {
                    $this->namespaces[$this->getName()] = array_merge($this->namespaces[$this->getName()] ?? [], explode(',', substr($line, strpos($line, ' ') + 1, -2)));
                }
                $i++;
            }
            // Get class content.
            $file->seek(parent::getStartLine() - 1);
            $length = $this->getEndLine() - parent::getStartLine() + 1;
            $i = 0;
            while ($i < $length) {
                $this->content .= $file->current();
                $file->next();
                $i++;
            }

            $namespace = $this->namespaces ? 'namespace ' . $this->getNamespaceName() . ';' . PHP_EOL . PHP_EOL : '';

            $use = $this->getUsageNamespaces() ? 'use ' . implode(',' . PHP_EOL, $this->getUsageNamespaces()) . PHP_EOL . PHP_EOL : '';

            $this->content = $namespace . $use . $this->content;
        }

        return $this->content;
    }

    /**
     * @return array
     */
    public function getUsageNamespaces()
    {
        return $this->namespaces[$this->getName()] ?? [];
    }

    /**
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    public function getGenerator()
    {

    }
}
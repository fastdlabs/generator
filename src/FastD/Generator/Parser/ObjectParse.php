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
class ObjectParse extends Parser implements ParserInterface
{
    /**
     * @var int
     */
    protected $startLine = 1;

    /**
     * @var MethodParser[]
     */
    protected $methods = [];

    /**
     * @var string
     */
    protected $content;

    /**
     * @var array
     */
    protected $namespaces = [];

    protected $reflection;

    /**
     * ObjectParse constructor.
     * @param mixed $class
     */
    public function __construct($class)
    {
        $this->reflection = new \ReflectionClass($class);

        $this->parseContent();
    }

    /**
     * @return int
     */
    public function getStartLine()
    {
        return $this->startLine;
    }

    public function getEndLine()
    {
        return $this->reflection->getEndLine();
    }

    /**
     * @param null $filter
     * @return MethodParser[]
     */
    public function getMethods($filter = null)
    {
        if (empty($this->methods)) {
            foreach ($this->reflection->getMethods($filter) as $method) {
                $this->methods[] = new MethodParser($method);
            }
        }

        return $this->methods;
    }

    /**
     * @return string
     */
    protected function parseContent()
    {
        if (empty($this->content)) {
            $file = new \SplFileObject($this->reflection->getFileName());
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
                    $this->namespaces[$this->reflection->getName()] = array_merge($this->namespaces[$this->reflection->getName()] ?? [], explode(',', substr($line, strpos($line, ' ') + 1, -2)));
                }
                $i++;
            }
            // Get class content.
            $file->seek($this->reflection->getStartLine()- 1);
            $length = $this->reflection->getEndLine() - $this->reflection->getStartLine() + 1;
            $i = 0;
            while ($i < $length) {
                $this->content .= $file->current();
                $file->next();
                $i++;
            }

            $namespace = $this->namespaces ? 'namespace ' . $this->reflection->getNamespaceName() . ';' . PHP_EOL . PHP_EOL : '';

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
        return $this->namespaces[$this->reflection->getName()] ?? [];
    }

    /**
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }
}
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
     * @var MethodParser[]
     */
    protected $methods = [];

    /**
     * @var PropertyParser[]
     */
    protected $properties = [];

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
     * @param mixed $class
     */
    public function __construct($class)
    {
        parent::__construct(new \ReflectionClass($class));

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
     * @return int
     */
    public function getEndLine()
    {
        return $this->reflector->getEndLine();
    }

    /**
     * @return MethodParser[]
     */
    public function getMethods()
    {
        if (empty($this->methods)) {
            foreach ($this->reflector->getMethods() as $method) {
                $this->methods[] = new MethodParser($method);
            }
        }

        return $this->methods;
    }

    /**
     * @return PropertyParser[]
     */
    public function getProperties()
    {
        if (empty($this->properties)) {
            foreach ($this->reflector->getProperties() as $property) {
                $this->properties[] = new PropertyParser($property);
            }
        }

        return $this->properties;
    }

    /**
     * @return string
     */
    protected function parseContent()
    {
        if (empty($this->content)) {
            $file = new \SplFileObject($this->reflector->getFileName());
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
                    $this->namespaces[$this->reflector->getName()] = array_merge($this->namespaces[$this->reflector->getName()] ?? [], explode(',', substr($line, strpos($line, ' ') + 1, -2)));
                }
                $i++;
            }
            // Get class content.
            $file->seek($this->reflector->getStartLine()- 1);
            $length = $this->reflector->getEndLine() - $this->reflector->getStartLine() + 1;
            $i = 0;
            while ($i < $length) {
                $this->content .= $file->current();
                $file->next();
                $i++;
            }

            $namespace = $this->namespaces ? 'namespace ' . $this->reflector->getNamespaceName() . ';' . PHP_EOL . PHP_EOL : '';

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
        return $this->namespaces[$this->reflector->getName()] ?? [];
    }

    /**
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }
}
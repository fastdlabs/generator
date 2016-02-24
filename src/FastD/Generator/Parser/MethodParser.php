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
     * @var ParamParser[]
     */
    protected $parameters = [];

    /**
     * @var \ReflectionMethod
     */
    protected $reflector;

    /**
     * @var string
     */
    protected $accessible;

    /**
     * @var string
     */
    protected $abstract = '';

    /**
     * @var string
     */
    protected $todo = '';

    /**
     * MethodParser constructor.
     * @param \ReflectionMethod $reflector
     */
    public function __construct(\ReflectionMethod $reflector)
    {
        parent::__construct($reflector);

        foreach ($this->reflector->getParameters() as $parameter) {
            $this->parameters[$parameter->getName()] = new ParamParser($parameter);
        }

        if ($this->reflector->isPrivate()) {
            $this->accessible = 'private';
        } else if ($this->reflector->isProtected()) {
            $this->accessible = 'protected';
        } else {
            $this->accessible = 'public';
        }

        $this->abstract = $this->reflector->isAbstract() ? 'abstract ' : '';

        if (empty($this->abstract)) {
            $file = new \SplFileObject($this->reflector->getFileName());
            $start = $this->reflector->getStartLine();
            $end =  $this->reflector->getEndLine();
            $file->seek($start);
            while ($start < $end) {
                $this->todo .= $file->current();
                $file->next();
                $start++;
            }
        } else {
            $this->todo = ';';
        }
        $this->todo = trim($this->todo);
    }

    /**
     * @param $name
     * @return ParamParser
     */
    public function getParameter($name)
    {
        return isset($this->parameters[$name]) ? $this->parameters[$name] : null;
    }

    /**
     * @return ParamParser[]
     */
    public function getParameters()
    {
        return $this->parameters;
    }

    /**
     * @return string
     */
    public function getContent()
    {
        $parameters = [];

        foreach ($this->parameters as $parameter) {
            $parameters[] = $parameter->getContent();
        }

        $parameters = implode(', ', $parameters);

        return <<<M
    {$this->abstract}{$this->accessible} function {$this->reflector->getName()}($parameters)
    {$this->todo}
M;

    }
}
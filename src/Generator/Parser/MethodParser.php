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

use FastD\Generator\Factory\Method;

/**
 * Class MethodParser
 *
 * @package FastD\Generator\Parser
 */
class MethodParser extends Parser implements ParserInterface
{
    /**
     * @var \ReflectionMethod
     */
    protected $reflector;

    /**
     * MethodParser constructor.
     * @param \ReflectionMethod $reflector
     */
    public function __construct(\ReflectionMethod $reflector)
    {
        parent::__construct($reflector);

        $params = [];
        foreach ($this->reflector->getParameters() as $parameter) {
            $params[] = (new ParamParser($parameter))->getGenerator();
        }

        if ($this->reflector->isPrivate()) {
            $accessible = Method::METHOD_ACCESS_PRIVATE;
        } else if ($this->reflector->isProtected()) {
            $accessible = Method::METHOD_ACCESS_PROTECTED;
        } else {
            $accessible = Method::METHOD_ACCESS_PUBLIC;
        }

        if ($this->reflector->isAbstract()) {
            $type = Method::METHOD_ABSTRACT;
        } else {
            $type = Method::METHOD_NULL;
        }

        $todo = '';

        if (empty($this->abstract)) {
            $file = new \SplFileObject($this->reflector->getFileName());
            $start = $this->reflector->getStartLine();
            $end =  $this->reflector->getEndLine();
            $file->seek($start);
            while ($start < $end) {
                $todo .= $file->current();
                $file->next();
                $start++;
            }
            unset($file);
        } else {
            $todo = ';';
        }

        $todo = trim($todo);
        $todo = trim(trim($todo, '{'), '}');

        $this->generator = new Method($this->reflector->getName(), $accessible, $type, $this->reflector->getDocComment());

        $this->generator->setParams($params);

        $this->generator->setTodo($todo);
    }

    /**
     * @return string
     */
    public function getContent()
    {
        return $this->generator->generate();
    }
}
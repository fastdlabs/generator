<?php
/**
 * Created by PhpStorm.
 * User: janhuang
 * Date: 16/2/19
 * Time: 下午6:18
 * Github: https://www.github.com/janhuang
 * Coding: https://www.coding.net/janhuang
 * SegmentFault: http://segmentfault.com/u/janhuang
 * Blog: http://segmentfault.com/blog/janhuang
 * Gmail: bboyjanhuang@gmail.com
 * WebSite: http://www.janhuang.me
 */

namespace FastD\Generator\Factory;

/**
 * Class Method
 *
 * @package FastD\Generator\Factory
 */
class Method extends Generate
{
    const METHOD_ACCESS_PUBLIC      = 'public';
    const METHOD_ACCESS_PROTECTED   = 'protected';
    const METHOD_ACCESS_PRIVATE     = 'private';

    const METHOD_NULL       = 'default';
    const METHOD_ABSTRACT   = 'abstract';
    const METHOD_INTERFACE  = 'interface';
    const METHOD_STATIC     = 'static';

    /**
     * @var Param[]
     */
    protected $params = [];

    /**
     * @var string
     */
    protected $access;

    /**
     * @var string
     */
    protected $todo = '// TODO...';

    /**
     * Method constructor.
     * @param $name
     * @param string $access
     * @param string $type
     * @param null $desc
     */
    public function __construct($name, $access = self::METHOD_ACCESS_PUBLIC, $type = self::METHOD_NULL, $desc = null)
    {
        $this->access = $access;

        parent::__construct($name, $type, $desc);
    }

    /**
     * @param Param[] $params
     * @return $this
     */
    public function setParams(array $params)
    {
        $this->params = $params;

        return $this;
    }

    /**
     * @return Param[]
     */
    public function getParams()
    {
        return $this->params;
    }

    /**
     * @param $todo
     * @return $this
     */
    public function setTodo($todo)
    {
        if (!empty($todo)) {
            $this->todo = $todo;
        }

        return $this;
    }

    /**
     * @return string
     */
    public function getTodo()
    {
        return $this->todo;
    }

    /**
     * @return string
     */
    public function getAccess()
    {
        return $this->access;
    }

    /**
     * @return string
     */
    public function generate()
    {
        return $this->skeleton();
    }

    /**
     * @return string
     */
    public function skeleton()
    {
        $params = [];
        foreach ($this->params as $param) {
            $params[] = $param->generate();
        }
        $params = implode(', ', $params);

        $todo = trim($this->getTodo());

        switch ($this->getType()) {
            case self::METHOD_INTERFACE:
                return <<<M
    {$this->getAccess()} function {$this->name}({$params});
M;
                break;
            case self::METHOD_ABSTRACT:
                return <<<M
    {$this->getType()} {$this->getAccess()} function {$this->name}({$params});
M;
                break;
            case self::METHOD_STATIC:
                return <<<M
    {$this->getAccess()} {$this->getType()} function {$this->name}({$params})
    {
        {$todo}
    }
M;
                break;
            case self::METHOD_NULL:
            default:
                return <<<M
    {$this->getAccess()} function {$this->name}({$params})
    {
        {$todo}
    }
M;

        }
    }
}
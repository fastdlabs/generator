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

class GetSetter extends Generate
{
    protected $params;

    public function __construct($name, $type, array $params = [], $desc = null)
    {
        $this->params = $params;

        parent::__construct($name, $type, $desc);
    }

    public function generate()
    {
        $name = ucfirst($this->name);
        return <<<M
    /**
     * @return {$this->getType()}
     */
    public function get{$name}()
    {
        return \$this->{$this->name};
    }

    /**
     * @param {$this->getType()} \${$this->name}
     * @return \$this
     */
    public function set{$name}(\${$this->name})
    {
        \$this->{$this->name} = \${$this->name};

        return \$this;
    }
M;
    }
}
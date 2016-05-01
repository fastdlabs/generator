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
 * Class GetSetter
 *
 * @package FastD\Generator\Factory
 */
class GetSetter extends Method
{
    /**
     * GetSetter constructor.
     * @param $name
     * @param string $type
     */
    public function __construct($name, $type = 'mixed')
    {
        parent::__construct($name, Method::METHOD_ACCESS_PUBLIC, $type, '');
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
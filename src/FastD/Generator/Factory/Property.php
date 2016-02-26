<?php
/**
 * Created by PhpStorm.
 * User: janhuang
 * Date: 16/2/19
 * Time: 下午6:06
 * Github: https://www.github.com/janhuang
 * Coding: https://www.coding.net/janhuang
 * SegmentFault: http://segmentfault.com/u/janhuang
 * Blog: http://segmentfault.com/blog/janhuang
 * Gmail: bboyjanhuang@gmail.com
 * WebSite: http://www.janhuang.me
 */

namespace FastD\Generator\Factory;

/**
 * Class Property
 *
 * @package FastD\Generator\Factory
 */
class Property extends Generate
{
    const PROPERTY_CONST     = 'const';
    const PROPERTY_ACCESS_PUBLIC    = 'public';
    const PROPERTY_ACCESS_PROTECTED = 'protected';
    const PROPERTY_ACCESS_PRIVATE   = 'private';
    const PROPERTY_ACCESS_STATIC    = 'static ';

    /**
     * @var string
     */
    protected $access;

    /**
     * @var string
     */
    protected $value;

    /**
     * @var string
     */
    protected $static;

    /**
     * Property constructor.
     * @param $name
     * @param string $access
     * @param string $type
     * @param null $desc
     */
    public function __construct($name, $access = self::PROPERTY_ACCESS_PROTECTED, $type = 'mixed', $desc = null)
    {
        $this->access = $access;

        parent::__construct($name, $type, $desc);
    }

    /**
     * @return string
     */
    public function getAccess()
    {
        return $this->access;
    }

    /**
     * @return $this
     */
    public function setStatic()
    {
        $this->static = self::PROPERTY_ACCESS_STATIC;

        return $this;
    }

    /**
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param $value
     * @return $this
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
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
        if ($this->getAccess() == self::PROPERTY_CONST) {
            $name = strtoupper($this->name);
            $value = $this->getValue() ? $this->getValue() : 'null';

            if (is_array($value)) {
                $value = var_export($value, true);
            }

            return <<<M
    /**
     * @const {$this->getType()}
     */
    {$this->getAccess()} {$name} = {$value};
M;
        }
        return <<<M
    /*
     * @var {$this->getType()}
     */
    {$this->getAccess()} {$this->static}\${$this->name};
M;
    }
}
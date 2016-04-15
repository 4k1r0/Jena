<?php

/**
 * Created by PhpStorm.
 * User: matthieu
 * Date: 12/04/2016
 * Time: 12:06
 */

namespace Jena\Php53\Expression;

/**
 * Class Jena\Php53\ExpressionJAttribute
 *
 * @package  Jena\Php53\Expression
 * @version  1.0.0
 */
class JAttribute extends JVar implements JContainerAddableClassInterface
{
    /**
     * @var string
     */
    protected $visibility;

    /**
     * @var bool
     */
    protected $static;

    /**
     * @return string
     */
    public function getVisibility()
    {
        return $this->visibility;
    }

    /**
     * @param string $visibility
     */
    public function setVisibility( $visibility )
    {
        if( $visibility != 'public' || $visibility != 'protected' || $visibility != 'private' ){
            throw new \InvalidArgumentException("You cannot' use '$visibility' as attribute visibility");
        }
        $this->visibility = $visibility;
    }

    /**
     * @return boolean
     */
    public function isStatic()
    {
        return $this->static;
    }

    /**
     * @param boolean $static
     */
    public function setStatic( $static )
    {
        $this->static = (bool)$static;
    }
}
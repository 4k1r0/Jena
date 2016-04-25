<?php

/**
 * Created by PhpStorm.
 * User: matthieu
 * Date: 12/04/2016
 * Time: 12:06
 */

namespace Jena\Php53\Expression;


use Jena\Php53\Container\JContainerAddableClassInterface;
use Jena\Php53\JBase;

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
    protected $visibility = 'public';

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
        if( $visibility != 'public' && $visibility != 'protected' && $visibility != 'private' ){
            throw new \InvalidArgumentException("You cannot' use '$visibility' as attribute visibility");
        }
        $this->visibility = $visibility;

        return $this;
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

        return $this;
    }

     /**
     * Get code
     *
     * @return string
     *
     * @author Matthieu Dos Santos <m.dossantos@santiane.fr>
     */
    public function getDeclaration()
    {
        if( $this->isStatic() ){
            $sStatic =  'static' . JBase::SPACE;
        } else {
            $sStatic = '';
        }

        return $this->getVisibility(). JBase::SPACE . $sStatic . parent::getDeclaration();
    }
}
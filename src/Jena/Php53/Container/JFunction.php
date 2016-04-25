<?php
/**
 * Created by PhpStorm.
 * User: matthieu
 * Date: 25/04/2016
 * Time: 16:36
 */

namespace Jena\Php53\Container;


use Jena\Php53\Expression\JParameter;
use Jena\Php53\JBase;
use Jena\Php53\JComponent;
use Jena\Php53\JReservedword;
use Jena\Php53\JType;

class JFunction extends JComponent
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var array
     */
    protected $aParameters;

    /**
     * @var string
     */
    protected $return;

    /**
     * JFunction constructor.
     *
     * @param string $name
     */
    public function __construct( $name )
    {
        $this->setName($name);
    }

    /**
     * Set function name
     *
     * @param string $name
     *
     * @return $this
     *
     * @author Matthieu Dos Santos <m.dossantos@santiane.fr>
     */
    public function setName( $name )
    {
        if ( !JReservedword::canIUse($name) || preg_match('/\W+/', $name) ) {
            throw new \InvalidArgumentException("You cannot' use '$name' as class name");
        }

        $this->name = $name;

        return $this;
    }

    /**
     * Add a param to the function declaration
     *
     * @param \Jena\Php53\Expression\JParameter $oParameter
     *
     * @return $this
     *
     * @author Matthieu Dos Santos <m.dossantos@santiane.fr>
     */
    public function setParameter( JParameter $oParameter )
    {
        $this->aParameters[ $oParameter->getName() ] = $oParameter;

        // Sort to place parameters without default value in first positions
        uasort($this->aParameters, function($a, $b){
            if (is_null($a->getDefault()) && !is_null($b->getDefault()))
                return -1;
            elseif (!is_null($a->getDefault()) && is_null($b->getDefault()))
                return 1;
            else
                return strcmp($a->getName(), $b->getName());
        });

        return $this;
    }

    /**
     * @param string $return
     */
    public function setReturn( $return )
    {
        if( !in_array($return, JType::getArray()) ){
            throw new \InvalidArgumentException("You cannot' use '$return' as return type");
        }

        $this->return = $return;

        return $this;
    }

    /**
     * Get function name
     *
     * @return string
     *
     * @author Matthieu Dos Santos <m.dossantos@santiane.fr>
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getReturn()
    {
        return $this->return;
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
        $aParams = array();
        foreach ( $this->aParameters as $oParameter ){
            $aParams[] = $oParameter->getDeclaration();
        }

        $code = 'function' . JBase::SPACE . $this->getName();
        $code .= '(' . implode(JBase::SEPARATOR_ITEM.JBase::SPACE, $aParams) . ')';

        $code .= JBase::EOL . JContainer::OPEN . JBase::EOL;

        $code .= JBase::EOL . JContainer::CLOSE . JBase::EOL;

        return $code;
    }
}
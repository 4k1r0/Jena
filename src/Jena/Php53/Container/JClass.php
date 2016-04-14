<?php

/**
 * Created by PhpStorm.
 * User: matthieu
 * Date: 12/04/2016
 * Time: 12:06
 */

namespace Jena\Php53\Container;

use Jena\Php53\JBase;
use Jena\Php53\JReservedword;

class JClass extends JContainer
{
    protected $namespace;
    protected $name;
    protected $extends;
    protected $aImplements = array();
    protected $aAttributes;
    protected $aMethods;

    public function __construct( $name )
    {
        $this->setName($name);
    }

    public function setName( $name )
    {
        if ( !JReservedword::canIUse($name) || preg_match('/\W+/', $name) ) {
            throw new \InvalidArgumentException("You cannot' use '$name' as class name");
        }

        $this->name = $name;

        return $this;
    }

    public function setNamespace( $namespace )
    {
        if ( !JReservedword::canIUse($namespace) || !preg_match('/^\w(\w|\\\)+$/', $namespace) ) {
            throw new \InvalidArgumentException("You cannot' use '$namespace' as namespace");
        }

        $this->namespace = $namespace;

        return $this;
    }

    public function setExtends( $extends )
    {
        if ( !JReservedword::canIUse($extends) || !preg_match('/^(\w|\\\)+$/', $extends) ) {
            throw new \InvalidArgumentException("You cannot' use '$extends' as extends class name");
        }

        $this->extends = $extends;

        return $this;
    }

    public function setImplements( $mImplements )
    {
        if ( !is_array($mImplements) )
            $mImplements = array( $mImplements );

        foreach ( $mImplements as $sImplements ) {
            if ( !JReservedword::canIUse($sImplements) || !preg_match('/^(\w|\\\)+$/', $sImplements) ) {
                throw new \InvalidArgumentException("You cannot' use '$sImplements' as interface name");
            }
        }

        $this->aImplements = array_merge($mImplements, $this->aImplements);

        return $this;
    }

    public function add(JContainerAddableClassInterface $addable)
    {
        var_dump(get_class($addable));
        switch( get_class($addable) ){
            case 'JMethod':
                $this->aMethods[] = $addable;
                break;
            case 'JAttribute':
                $this->aAttributes[] = $addable;
                break;
        }
    }

    public function getDeclaration()
    {
        $code = 'class' . JBase::SPACE . $this->name;

        if ( !empty($this->extends) ) {
            $code .= JBase::SPACE . 'extends' . JBase::SPACE . $this->extends;
        }

        if ( !empty($this->aImplements) ) {
            $code .= JBase::SPACE . 'implements' . JBase::SPACE . implode(', ', $this->aImplements);
        }

        $code .= JBase::EOL . JContainer::OPEN . JBase::EOL;
        $code .= JBase::EOL . JContainer::CLOSE . JBase::EOL;

        return $code;
    }
}
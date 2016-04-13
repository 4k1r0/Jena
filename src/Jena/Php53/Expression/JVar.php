<?php
/**
 * Created by PhpStorm.
 * User: matthieu
 * Date: 13/04/2016
 * Time: 16:18
 */

namespace Jena\Php53\Expression;


use Jena\Php53\JBase;
use Jena\Php53\JType;

class JVar
{
    protected $type;
    protected $name;
    protected $default;
    
    public function __construct( $name )
    {
        $this->setName($name);
    }

    public function setName( $name )
    {
        if ( preg_match('/\W+/', $name) ) {
            throw new \InvalidArgumentException("You cannot' use '$name' as var name");
        }

        $this->name = $name;

        return $this;
    }

    public function setType( $type ){

        if( !in_array($type, JType::getArray()) ){
            throw new \InvalidArgumentException("You cannot' use '$type' as var type");
        }

        $this->type = $type;

        return $this;
    }

    public function setDefault( $default ){

        $this->default = JType::cast($this->type, $default);

        return $this;
    }
}
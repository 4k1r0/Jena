<?php

/**
 * Created by PhpStorm.
 * User: matthieu
 * Date: 12/04/2016
 * Time: 12:06
 */

namespace Jena\Php53\Container;

class JMethod extends JFunction implements JContainerAddableClassInterface
{
    public function getName()
    {
        // TODO: Implement getName() method.
    }

    public static function getClass(){
        return get_called_class();
    }
}
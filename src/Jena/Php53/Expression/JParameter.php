<?php

/**
 * Created by PhpStorm.
 * User: matthieu
 * Date: 12/04/2016
 * Time: 12:07
 */

namespace Jena\Php53\Expression;

use Jena\Php53\JBase;
use Jena\Php53\JOperator;
use Jena\Php53\JType;

class JParameter extends JVar
{
    /**
     * Get code
     *
     * @return string
     *
     * @author Matthieu Dos Santos <m.dossantos@santiane.fr>
     */
    public function getDeclaration()
    {
        $code = JBase::VAR_SIGN . $this->getName();
        if( isset($this->default) ){
            $code .= JBase::SPACE . JOperator::EQUALS . JBase::SPACE . JType::jPrint($this->default, true);
        }

        return $code;
    }
}
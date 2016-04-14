<?php
/**
 * Created by PhpStorm.
 * User: matthieu
 * Date: 13/04/2016
 * Time: 16:18
 */

namespace Jena\Php53\Expression;


use Jena\Php53\Container\JContainerAddableInterface;
use Jena\Php53\JBase;
use Jena\Php53\JOperator;
use Jena\Php53\JType;

/**
 * Class Jena\Php53\ExpressionJVar
 *
 * @package  Jena\Php53\Expression
 * @version  1.0.0
 */
class JVar implements JContainerAddableInterface
{
    /**
     * @var string
     */
    protected $type;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var mixed
     */
    protected $default;

    /**
     * JVar constructor.
     *
     * @param string $name
     */
    public function __construct( $name )
    {
        $this->setName($name);
    }

    /**
     * Set var name
     *
     * @param string $name
     *
     * @return $this
     *
     * @author Matthieu Dos Santos <m.dossantos@santiane.fr>
     */
    public function setName( $name )
    {
        if ( preg_match('/\W+/', $name) ) {
            throw new \InvalidArgumentException("You cannot' use '$name' as var name");
        }

        $this->name = $name;

        return $this;
    }

    /**
     * Set var type
     *
     * @param string $type
     *
     * @return $this
     *
     * @author Matthieu Dos Santos <m.dossantos@santiane.fr>
     */
    public function setType( $type ){

        if( !in_array($type, JType::getArray()) ){
            throw new \InvalidArgumentException("You cannot' use '$type' as var type");
        }

        $this->type = $type;

        return $this;
    }

    /**
     * Set default value
     *
     * @param mixed $default
     *
     * @return $this
     *
     * @author Matthieu Dos Santos <m.dossantos@santiane.fr>
     */
    public function setDefault( $default ){

        $this->default = JType::cast($this->type, $default);

        return $this;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getDefault()
    {
        return $this->default;
    }

    public function getDeclaration()
    {
        $php = JBase::VAR_SIGN . $this->getName();
        if( isset($this->default) ){
            $php .= JBase::SPACE . JOperator::EQUALS . JBase::SPACE . JType::jPrint($this->default, true);
        }
        $php .= JBase::SEPARATOR_EXP . JBase::EOL;

        return $php;
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: matthieu
 * Date: 13/04/2016
 * Time: 16:33
 */

namespace Jena\Php53;

class JType
{
    public static function getArray()
    {
        return array(
            'int',
            'integer',
            'float',
            'double',
            'real',
            'bool',
            'boolean',
            'string',
            'array',
            'closure',
            'resource',
            'mixed',
            'object',
        );
    }

    public static function getCaster( $type )
    {
        switch( $type ){
            case 'int':
            case 'integer':
                return 'intval';
                break;
            case 'float':
            case 'double':
            case 'real':
                return 'floatval';
                break;
            case 'bool':
            case 'boolean':
                return 'boolval';
                break;
            case 'string':
                return function($value){
                    return (string)$value;
                };
                break;
            case 'array':
                return function($value){
                    return (array)$value;
                };
                break;
            case 'object':
                return function($value){
                    return (object)$value;
                };
                break;
            default:
                return function($value){
                    return $value;
                };
        }
    }

    public static function getValidator( $type, $strict = false )
    {
        if( $strict ) {
            switch ( $type ) {
                case 'int':
                case 'integer':
                    return 'is_int';
                    break;
                case 'float':
                case 'double':
                case 'real':
                    return 'is_float';
                    break;
                case 'bool':
                case 'boolean':
                    return 'is_bool';
                    break;
                case 'string':
                    return 'is_string';
                    break;
                case 'array':
                    return 'is_array';
                    break;
                case 'closure':
                    return 'is_callable';
                    break;
                case 'resource':
                    return 'is_resource';
                    break;
                case 'object':
                    return 'is_object';
                    break;
                case 'mixed':
                default:
                    return 'isset';
            }
        } else {
            switch ( $type ) {
                case 'int':
                case 'integer':
                case 'float':
                case 'double':
                case 'real':
                case 'bool':
                case 'boolean':
                    return 'is_numeric';
                    break;
                case 'array':
                    return 'is_array';
                    break;
                case 'closure':
                    return 'is_callable';
                    break;
                case 'resource':
                    return 'is_resource';
                    break;
                case 'object':
                    return 'is_object';
                    break;
                case 'string':
                case 'mixed':
                default:
                    return 'isset';
            }
        }
    }

    public static function cast( $type, $value )
    {
        if( in_array($type, self::getArray()) ){
            $caster = self::getCaster($type);
            return $caster($value);
        }
    }

    public static function jPrint( $value )
    {
        $type = gettype($value);
        switch($type){
            case 'array':
                $print = 'array(';
                $array = array();
                foreach ( $value as $index => $item ){
                    $array[] = self::jPrint($index).' => ' . self::jPrint($item);
                }
                $print .= implode(JBase::SEPARATOR_ITEM, $array) . ')';
                break;
            case 'string':
                $print = JBase::QUOTE_SIMPLE . $value . JBase::QUOTE_SIMPLE;
                break;
            case 'bool':
            case 'boolean':
                $print = $value ? 'true' : 'false';
                break;
            default:
                $print = $value;
        }

        return $print;
    }
}
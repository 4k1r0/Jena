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
    public static function getArray(){
        return array(
            'int',
            'float',
            'bool',
            'string',
            'array',
            'closure',
            'resource',
            'mixed',
            'object',
        );
    }

    public static function getCaster( $type ){
        switch( $type ){
            case 'int':
                return 'intval';
                break;
            case 'float':
                return 'floatval';
                break;
            case 'bool':
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

    public static function getValidator( $type, $strict = false ){

        if( $strict ) {
            switch ( $type ) {
                case 'int':
                    return 'is_int';
                    break;
                case 'float':
                    return 'is_float';
                    break;
                case 'bool':
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
                case 'float':
                case 'bool':
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

    public static function cast( $type, $value ){
        if( in_array($type, self::getArray()) ){
            $caster = self::getCaster($type);
            return $caster($value);
        }
    }


}
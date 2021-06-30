<?php

namespace Container835hLc0;

include_once \dirname(__DIR__, 4).'/src/phpDocumentor/Descriptor/Filter/Filter.php';
class Filter_6ae6af3 extends \phpDocumentor\Descriptor\Filter\Filter implements \ProxyManager\Proxy\VirtualProxyInterface
{
    private $valueHolderea22a = null;
    private $initializerb1e44 = null;
    private static $publicProperties4c681 = [
        
    ];
    public function filter(\phpDocumentor\Descriptor\Filter\Filterable $descriptor) : ?\phpDocumentor\Descriptor\Filter\Filterable
    {
        $this->initializerb1e44 && ($this->initializerb1e44->__invoke($valueHolderea22a, $this, 'filter', array('descriptor' => $descriptor), $this->initializerb1e44) || 1) && $this->valueHolderea22a = $valueHolderea22a;
        return $this->valueHolderea22a->filter($descriptor);
    }
    public static function staticProxyConstructor($initializer)
    {
        static $reflection;
        $reflection = $reflection ?? new \ReflectionClass(__CLASS__);
        $instance   = $reflection->newInstanceWithoutConstructor();
        \Closure::bind(function (\phpDocumentor\Descriptor\Filter\Filter $instance) {
            unset($instance->pipeline);
        }, $instance, 'phpDocumentor\\Descriptor\\Filter\\Filter')->__invoke($instance);
        $instance->initializerb1e44 = $initializer;
        return $instance;
    }
    public function __construct(iterable $filters)
    {
        static $reflection;
        if (! $this->valueHolderea22a) {
            $reflection = $reflection ?? new \ReflectionClass('phpDocumentor\\Descriptor\\Filter\\Filter');
            $this->valueHolderea22a = $reflection->newInstanceWithoutConstructor();
        \Closure::bind(function (\phpDocumentor\Descriptor\Filter\Filter $instance) {
            unset($instance->pipeline);
        }, $this, 'phpDocumentor\\Descriptor\\Filter\\Filter')->__invoke($this);
        }
        $this->valueHolderea22a->__construct($filters);
    }
    public function & __get($name)
    {
        $this->initializerb1e44 && ($this->initializerb1e44->__invoke($valueHolderea22a, $this, '__get', ['name' => $name], $this->initializerb1e44) || 1) && $this->valueHolderea22a = $valueHolderea22a;
        if (isset(self::$publicProperties4c681[$name])) {
            return $this->valueHolderea22a->$name;
        }
        $realInstanceReflection = new \ReflectionClass('phpDocumentor\\Descriptor\\Filter\\Filter');
        if (! $realInstanceReflection->hasProperty($name)) {
            $targetObject = $this->valueHolderea22a;
            $backtrace = debug_backtrace(false, 1);
            trigger_error(
                sprintf(
                    'Undefined property: %s::$%s in %s on line %s',
                    $realInstanceReflection->getName(),
                    $name,
                    $backtrace[0]['file'],
                    $backtrace[0]['line']
                ),
                \E_USER_NOTICE
            );
            return $targetObject->$name;
        }
        $targetObject = $this->valueHolderea22a;
        $accessor = function & () use ($targetObject, $name) {
            return $targetObject->$name;
        };
        $backtrace = debug_backtrace(true, 2);
        $scopeObject = isset($backtrace[1]['object']) ? $backtrace[1]['object'] : new \ProxyManager\Stub\EmptyClassStub();
        $accessor = $accessor->bindTo($scopeObject, get_class($scopeObject));
        $returnValue = & $accessor();
        return $returnValue;
    }
    public function __set($name, $value)
    {
        $this->initializerb1e44 && ($this->initializerb1e44->__invoke($valueHolderea22a, $this, '__set', array('name' => $name, 'value' => $value), $this->initializerb1e44) || 1) && $this->valueHolderea22a = $valueHolderea22a;
        $realInstanceReflection = new \ReflectionClass('phpDocumentor\\Descriptor\\Filter\\Filter');
        if (! $realInstanceReflection->hasProperty($name)) {
            $targetObject = $this->valueHolderea22a;
            $targetObject->$name = $value;
            return $targetObject->$name;
        }
        $targetObject = $this->valueHolderea22a;
        $accessor = function & () use ($targetObject, $name, $value) {
            $targetObject->$name = $value;
            return $targetObject->$name;
        };
        $backtrace = debug_backtrace(true, 2);
        $scopeObject = isset($backtrace[1]['object']) ? $backtrace[1]['object'] : new \ProxyManager\Stub\EmptyClassStub();
        $accessor = $accessor->bindTo($scopeObject, get_class($scopeObject));
        $returnValue = & $accessor();
        return $returnValue;
    }
    public function __isset($name)
    {
        $this->initializerb1e44 && ($this->initializerb1e44->__invoke($valueHolderea22a, $this, '__isset', array('name' => $name), $this->initializerb1e44) || 1) && $this->valueHolderea22a = $valueHolderea22a;
        $realInstanceReflection = new \ReflectionClass('phpDocumentor\\Descriptor\\Filter\\Filter');
        if (! $realInstanceReflection->hasProperty($name)) {
            $targetObject = $this->valueHolderea22a;
            return isset($targetObject->$name);
        }
        $targetObject = $this->valueHolderea22a;
        $accessor = function () use ($targetObject, $name) {
            return isset($targetObject->$name);
        };
        $backtrace = debug_backtrace(true, 2);
        $scopeObject = isset($backtrace[1]['object']) ? $backtrace[1]['object'] : new \ProxyManager\Stub\EmptyClassStub();
        $accessor = $accessor->bindTo($scopeObject, get_class($scopeObject));
        $returnValue = $accessor();
        return $returnValue;
    }
    public function __unset($name)
    {
        $this->initializerb1e44 && ($this->initializerb1e44->__invoke($valueHolderea22a, $this, '__unset', array('name' => $name), $this->initializerb1e44) || 1) && $this->valueHolderea22a = $valueHolderea22a;
        $realInstanceReflection = new \ReflectionClass('phpDocumentor\\Descriptor\\Filter\\Filter');
        if (! $realInstanceReflection->hasProperty($name)) {
            $targetObject = $this->valueHolderea22a;
            unset($targetObject->$name);
            return;
        }
        $targetObject = $this->valueHolderea22a;
        $accessor = function () use ($targetObject, $name) {
            unset($targetObject->$name);
            return;
        };
        $backtrace = debug_backtrace(true, 2);
        $scopeObject = isset($backtrace[1]['object']) ? $backtrace[1]['object'] : new \ProxyManager\Stub\EmptyClassStub();
        $accessor = $accessor->bindTo($scopeObject, get_class($scopeObject));
        $accessor();
    }
    public function __clone()
    {
        $this->initializerb1e44 && ($this->initializerb1e44->__invoke($valueHolderea22a, $this, '__clone', array(), $this->initializerb1e44) || 1) && $this->valueHolderea22a = $valueHolderea22a;
        $this->valueHolderea22a = clone $this->valueHolderea22a;
    }
    public function __sleep()
    {
        $this->initializerb1e44 && ($this->initializerb1e44->__invoke($valueHolderea22a, $this, '__sleep', array(), $this->initializerb1e44) || 1) && $this->valueHolderea22a = $valueHolderea22a;
        return array('valueHolderea22a');
    }
    public function __wakeup()
    {
        \Closure::bind(function (\phpDocumentor\Descriptor\Filter\Filter $instance) {
            unset($instance->pipeline);
        }, $this, 'phpDocumentor\\Descriptor\\Filter\\Filter')->__invoke($this);
    }
    public function setProxyInitializer(\Closure $initializer = null) : void
    {
        $this->initializerb1e44 = $initializer;
    }
    public function getProxyInitializer() : ?\Closure
    {
        return $this->initializerb1e44;
    }
    public function initializeProxy() : bool
    {
        return $this->initializerb1e44 && ($this->initializerb1e44->__invoke($valueHolderea22a, $this, 'initializeProxy', array(), $this->initializerb1e44) || 1) && $this->valueHolderea22a = $valueHolderea22a;
    }
    public function isProxyInitialized() : bool
    {
        return null !== $this->valueHolderea22a;
    }
    public function getWrappedValueHolderValue()
    {
        return $this->valueHolderea22a;
    }
}

if (!\class_exists('Filter_6ae6af3', false)) {
    \class_alias(__NAMESPACE__.'\\Filter_6ae6af3', 'Filter_6ae6af3', false);
}

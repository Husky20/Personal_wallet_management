<?php

namespace Container835hLc0;

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

/*
 * @internal This class has been auto-generated by the Symfony Dependency Injection Component.
 */
class getParserService extends phpDocumentor_KernelProdContainer
{
    /*
     * Gets the private 'phpDocumentor\Parser\Parser' shared autowired service.
     *
     * @return \phpDocumentor\Parser\Parser
     */
    public static function do($container, $lazyLoad = true)
    {
        include_once \dirname(__DIR__, 4).'/src/phpDocumentor/Parser/Parser.php';
        include_once \dirname(__DIR__, 5).'/reflection-common/src/ProjectFactory.php';
        include_once \dirname(__DIR__, 5).'/reflection/src/phpDocumentor/Reflection/Php/ProjectFactory.php';
        include_once \dirname(__DIR__, 5).'/reflection/src/phpDocumentor/Reflection/Php/ProjectFactoryStrategy.php';
        include_once \dirname(__DIR__, 5).'/reflection/src/phpDocumentor/Reflection/Php/Factory/AbstractFactory.php';
        include_once \dirname(__DIR__, 5).'/reflection/src/phpDocumentor/Reflection/Php/Factory/Argument.php';
        include_once \dirname(__DIR__, 6).'/nikic/php-parser/lib/PhpParser/PrettyPrinterAbstract.php';
        include_once \dirname(__DIR__, 6).'/nikic/php-parser/lib/PhpParser/PrettyPrinter/Standard.php';
        include_once \dirname(__DIR__, 5).'/reflection/src/phpDocumentor/Reflection/Php/Factory/Class_.php';
        include_once \dirname(__DIR__, 5).'/reflection/src/phpDocumentor/Reflection/Php/Factory/ClassConstant.php';
        include_once \dirname(__DIR__, 5).'/reflection/src/phpDocumentor/Reflection/Php/Factory/GlobalConstant.php';
        include_once \dirname(__DIR__, 5).'/reflection/src/phpDocumentor/Reflection/Php/Factory/DocBlock.php';
        include_once \dirname(__DIR__, 5).'/reflection-docblock/src/DocBlockFactoryInterface.php';
        include_once \dirname(__DIR__, 5).'/reflection-docblock/src/DocBlockFactory.php';
        include_once \dirname(__DIR__, 5).'/reflection/src/phpDocumentor/Reflection/Php/Factory/Function_.php';
        include_once \dirname(__DIR__, 5).'/reflection/src/phpDocumentor/Reflection/Php/Factory/Interface_.php';
        include_once \dirname(__DIR__, 5).'/reflection/src/phpDocumentor/Reflection/Php/Factory/Method.php';
        include_once \dirname(__DIR__, 5).'/reflection/src/phpDocumentor/Reflection/Php/Factory/Property.php';
        include_once \dirname(__DIR__, 5).'/reflection/src/phpDocumentor/Reflection/Php/Factory/Trait_.php';
        include_once \dirname(__DIR__, 5).'/reflection/src/phpDocumentor/Reflection/Php/Factory/File.php';
        include_once \dirname(__DIR__, 4).'/src/phpDocumentor/Parser/FileFactory.php';
        include_once \dirname(__DIR__, 5).'/reflection/src/phpDocumentor/Reflection/Php/NodesFactory.php';
        include_once \dirname(__DIR__, 6).'/symfony/stopwatch/Stopwatch.php';

        $a = new \PhpParser\PrettyPrinter\Standard();

        return $container->privates['phpDocumentor\\Parser\\Parser'] = new \phpDocumentor\Parser\Parser(new \phpDocumentor\Reflection\Php\ProjectFactory([0 => new \phpDocumentor\Reflection\Php\Factory\Argument($a), 1 => new \phpDocumentor\Reflection\Php\Factory\Class_(), 2 => new \phpDocumentor\Reflection\Php\Factory\ClassConstant($a), 3 => new \phpDocumentor\Reflection\Php\Factory\GlobalConstant($a), 4 => new \phpDocumentor\Reflection\Php\Factory\DocBlock(\phpDocumentor\Reflection\DocBlockFactory::createInstance()), 5 => new \phpDocumentor\Reflection\Php\Factory\Function_(), 6 => new \phpDocumentor\Reflection\Php\Factory\Interface_(), 7 => new \phpDocumentor\Reflection\Php\Factory\Method(), 8 => new \phpDocumentor\Reflection\Php\Factory\Property($a), 9 => new \phpDocumentor\Reflection\Php\Factory\Trait_(), 10 => \phpDocumentor\Parser\FileFactory::createInstance(\phpDocumentor\Reflection\Php\NodesFactory::createInstance(), new RewindableGenerator(function () use ($container) {
            yield 0 => ($container->privates['phpDocumentor\\Parser\\Middleware\\StopwatchMiddleware'] ?? $container->load('getStopwatchMiddlewareService'));
            yield 1 => ($container->privates['phpDocumentor\\Parser\\Middleware\\EmittingMiddleware'] ?? ($container->privates['phpDocumentor\\Parser\\Middleware\\EmittingMiddleware'] = new \phpDocumentor\Parser\Middleware\EmittingMiddleware()));
            yield 2 => ($container->privates['phpDocumentor\\Parser\\Middleware\\CacheMiddleware'] ?? $container->load('getCacheMiddlewareService'));
            yield 3 => ($container->privates['phpDocumentor\\Parser\\Middleware\\ErrorHandlingMiddleware'] ?? $container->load('getErrorHandlingMiddlewareService'));
            yield 4 => ($container->privates['phpDocumentor\\Parser\\Middleware\\ReEncodingMiddleware'] ?? ($container->privates['phpDocumentor\\Parser\\Middleware\\ReEncodingMiddleware'] = new \phpDocumentor\Parser\Middleware\ReEncodingMiddleware()));
        }, 5))]), ($container->privates['debug.stopwatch'] ?? ($container->privates['debug.stopwatch'] = new \Symfony\Component\Stopwatch\Stopwatch(true))), ($container->privates['monolog.logger'] ?? $container->load('getMonolog_LoggerService')));
    }
}

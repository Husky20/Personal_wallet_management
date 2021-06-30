<?php

namespace Container835hLc0;

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

/*
 * @internal This class has been auto-generated by the Symfony Dependency Injection Component.
 */
class getGraphService extends phpDocumentor_KernelProdContainer
{
    /*
     * Gets the private 'phpDocumentor\Transformer\Writer\Graph' shared autowired service.
     *
     * @return \phpDocumentor\Transformer\Writer\Graph
     */
    public static function do($container, $lazyLoad = true)
    {
        include_once \dirname(__DIR__, 4).'/src/phpDocumentor/Transformer/Writer/WriterAbstract.php';
        include_once \dirname(__DIR__, 4).'/src/phpDocumentor/Descriptor/ProjectDescriptor/WithCustomSettings.php';
        include_once \dirname(__DIR__, 4).'/src/phpDocumentor/Transformer/Writer/Graph.php';
        include_once \dirname(__DIR__, 4).'/src/phpDocumentor/Transformer/Writer/Graph/Generator.php';
        include_once \dirname(__DIR__, 4).'/src/phpDocumentor/Transformer/Writer/Graph/GraphVizClassDiagram.php';
        include_once \dirname(__DIR__, 4).'/src/phpDocumentor/Transformer/Writer/Graph/PlantumlClassDiagram.php';

        return $container->privates['phpDocumentor\\Transformer\\Writer\\Graph'] = new \phpDocumentor\Transformer\Writer\Graph(new \phpDocumentor\Transformer\Writer\Graph\GraphVizClassDiagram(), new \phpDocumentor\Transformer\Writer\Graph\PlantumlClassDiagram(($container->privates['monolog.logger'] ?? $container->load('getMonolog_LoggerService'))));
    }
}

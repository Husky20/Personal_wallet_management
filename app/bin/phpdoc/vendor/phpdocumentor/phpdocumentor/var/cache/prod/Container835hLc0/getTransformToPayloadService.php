<?php

namespace Container835hLc0;

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

/*
 * @internal This class has been auto-generated by the Symfony Dependency Injection Component.
 */
class getTransformToPayloadService extends phpDocumentor_KernelProdContainer
{
    /*
     * Gets the private 'phpDocumentor\Pipeline\Stage\TransformToPayload' shared autowired service.
     *
     * @return \phpDocumentor\Pipeline\Stage\TransformToPayload
     */
    public static function do($container, $lazyLoad = true)
    {
        include_once \dirname(__DIR__, 4).'/src/phpDocumentor/Pipeline/Stage/TransformToPayload.php';

        return $container->privates['phpDocumentor\\Pipeline\\Stage\\TransformToPayload'] = new \phpDocumentor\Pipeline\Stage\TransformToPayload(($container->privates['phpDocumentor\\Descriptor\\ProjectDescriptorBuilder'] ?? $container->load('getProjectDescriptorBuilderService')));
    }
}

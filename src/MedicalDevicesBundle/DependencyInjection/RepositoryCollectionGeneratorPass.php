<?php

/*
 * Copyright (C) 2017 Welpons <welpons@gmail.com>
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

namespace MedicalDevicesBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Description of RepositoryCollectionGeneratorPass
 *
 * @author Welpons <welpons@gmail.com>
 */
class RepositoryCollectionGeneratorPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        if (!$container->has('repository.collection.provider')) {
            return;
        }

        $definition = $container->findDefinition(
                'repository.collection.provider'
        );

        $taggedServices = $container->findTaggedServiceIds(
                'repository.factory'
        );

        foreach ($taggedServices as $id => $tags) {
            $definition->addMethodCall(
                    'addRepositoryFactory', array(new Reference($id))
            );
        }
    }

}

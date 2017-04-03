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

namespace Tests\MedicalDevicesBundle\Framework;

use MedicalDevices\Infrastructure\Persistence\RepositoryInterface;
use MedicalDevices\Infrastructure\Persistence\Doctrine\DoctrineRepository;

/**
 * Description of TestDoctrineRepository
 *
 * @author Welpons <welpons@gmail.com>
 */
class DoctrineTestRepository extends DoctrineRepository implements RepositoryInterface
{
    public function getName(): string
    {
        return 'test_doctrine';
    }

}

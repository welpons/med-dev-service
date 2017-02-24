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

namespace MedicalDevices\Infrastructure\Persistence\JsonFile;

/**
 * Description of JsonFileRepository
 *
 * @author Welpons <welpons@gmail.com>
 */
abstract class JsonFileRepository
{
    
    protected $raws = array();
    
    public function __construct(string $filePath)
    {
        if (empty($filePath)) {
            throw new UndefinedJsonFileException('Undefined file path. Impossible to read file');
        }
        
        if (!file_exists($filePath)) {
            throw new NotFoundJsonFileException(sprintf('File not found: %s', $filePath));
        }
        
        $content = $this->getFileContent($filePath);
        
        if (false === $content) {
            throw new UnreadableJsonFileException(sprintf('Imossible to read file content: %s', $filePath));
        }
        
        $array = json_decode($content, true);
        
        if (JSON_ERROR_NONE != json_last_error()) {
            throw new DecodingJsonFileException(sprintf('Error occurred during the last JSON decocoding. Error message: %s, content: %', json_last_error_msg(), $content));
        }
        
        $this->raws = $array;
    }
    
    private function getFileContent($filePath)
    {
        return file_get_contents($filePath);
    }        
}

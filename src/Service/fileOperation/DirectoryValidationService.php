<?php

namespace App\Service\fileOperation;


class DirectoryValidationService implements DirectoryValidation
{

    public function validate(string $directory)
    {
        return file_exists($directory);        
    }
  
}
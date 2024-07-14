<?php

namespace App\Service\fileOperation;

use Exception;
use Psr\Log\LoggerInterface;

class SaveJsonInFileService implements SaveJson
{
    private const filePath = __DIR__ . '/../../../request.json';

    private DirectoryValidation $directoryValidation;

    private LoggerInterface $logger;

    public function __construct(DirectoryValidation $directoryValidation, LoggerInterface $logger)
    {

        $this->directoryValidation = $directoryValidation;
        $this->logger = $logger;
    }

    public function save(string $json)
    {

        if (!$this->directoryValidation->validate(self::filePath)) {
            return false;
        }

        try {
            file_put_contents(self::filePath, $json);
        } catch (Exception $e) {
            $this->logger->error($e->getMessage());
            return false;
        }

        return true;
    }

}

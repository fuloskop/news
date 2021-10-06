<?php

namespace App\Logger\Base;

use App\Logger\Contact\LoggerInterface;
use App\Models\Log;
use App\Repositories\LogsRepository;

class Logger implements LoggerInterface
{
    protected $logsRepository;

    public function __construct(LogsRepository $logsRepository)
    {
        $this->logsRepository = $logsRepository;
    }

    public function error($message)
    {
        $this->logsRepository->store($message,__FUNCTION__);
    }

    public function debug($message)
    {
        $this->logsRepository->store($message,__FUNCTION__);
    }

    public function warning($message)
    {
        $this->logsRepository->store($message,__FUNCTION__);
    }

    public function critical($message)
    {
        $this->logsRepository->store($message,__FUNCTION__);
    }

    public function info($message)
    {
        $this->logsRepository->store($message,__FUNCTION__);
    }

    public function activity($message)
    {
        $this->logsRepository->store($message,__FUNCTION__);
    }
}

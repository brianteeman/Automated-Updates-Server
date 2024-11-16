<?php

namespace App\RemoteSite\Responses;

use App\DTO\BaseDTO;

class HealthCheck extends BaseDTO
{
    public function __construct(
        public string $php_version,
        public string $db_type,
        public string $db_version,
        public string $cms_version,
        public string $server_os
    ) {
    }
}

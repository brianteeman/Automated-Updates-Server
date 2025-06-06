<?php

namespace App\RemoteSite;

use App\Enum\HttpMethod;
use App\RemoteSite\Responses\FinalizeUpdate;
use App\RemoteSite\Responses\GetUpdate;
use App\RemoteSite\Responses\HealthCheck;
use App\RemoteSite\Responses\PrepareUpdate;
use App\RemoteSite\Responses\Notification;

enum WebserviceEndpoint: string
{
    case checkHealth = "/api/index.php/v1/joomlaupdate/healthcheck";
    case getUpdate = "/api/index.php/v1/joomlaupdate/getUpdate";
    case prepareUpdate = "/api/index.php/v1/joomlaupdate/prepareUpdate";
    case finalizeUpdate = "/api/index.php/v1/joomlaupdate/finalizeUpdate";
    case notificationSuccess = "/api/index.php/v1/joomlaupdate/notificationSuccess";
    case notificationFailed = "/api/index.php/v1/joomlaupdate/notificationFailed";

    public function getMethod(): HttpMethod
    {
        switch ($this->name) {
            case self::checkHealth->name:
            case self::getUpdate->name:
                return HttpMethod::GET;

                // no break
            case self::prepareUpdate->name:
            case self::finalizeUpdate->name:
            case self::notificationSuccess->name:
            case self::notificationFailed->name:
                return HttpMethod::POST;
        }

        throw new \ValueError("No method defined");
    }

    public function getResponseClass(): string
    {
        switch ($this->name) {
            case self::checkHealth->name:
                return HealthCheck::class;
            case self::getUpdate->name:
                return GetUpdate::class;
            case self::prepareUpdate->name:
                return PrepareUpdate::class;
            case self::finalizeUpdate->name:
                return FinalizeUpdate::class;
            case self::notificationSuccess->name:
            case self::notificationFailed->name:
                return Notification::class;
        }

        throw new \ValueError("No response defined");
    }

    public function getUrl(): string
    {
        return $this->value;
    }

    public static function tryFromName(string $name): ?static
    {
        $reflection = new \ReflectionEnum(static::class);

        if (!$reflection->hasCase($name)) {
            return null;
        }

        /** @var static */
        return $reflection->getCase($name)->getValue();
    }
}

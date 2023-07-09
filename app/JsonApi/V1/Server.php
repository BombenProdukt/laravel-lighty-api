<?php

declare(strict_types=1);

namespace App\JsonApi\V1;

use App\JsonApi\V1\Documents\DocumentSchema;
use App\JsonApi\V1\Languages\LanguageSchema;
use App\JsonApi\V1\Teams\TeamSchema;
use App\JsonApi\V1\Themes\ThemeSchema;
use LaravelJsonApi\Core\Server\Server as BaseServer;

final class Server extends BaseServer
{
    /**
     * The base URI namespace for this server.
     */
    protected string $baseUri = '/api/v1';

    /**
     * Get the server's list of schemas.
     */
    protected function allSchemas(): array
    {
        return [
            DocumentSchema::class,
            LanguageSchema::class,
            TeamSchema::class,
            ThemeSchema::class,
        ];
    }
}

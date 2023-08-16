<?php

declare(strict_types=1);

namespace Chocofamilyme\Authorizers;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;

class Rbac
{
    private ClientInterface $client;

    public function __construct(string $baseUri, int $timeout = 10)
    {
        $this->client = new Client([
            'base_uri' => $baseUri,
            'timeout'  => $timeout,
        ]);
    }

    /**
     * @throws GuzzleException
     * @throws ForbiddenException
     */
    public function authorizeByTerminal(int $userId, string $permission, int $terminalId): void
    {
        $this->authorizeByTeam($userId, $permission, "filial-$terminalId");
    }

    /**
     * @throws GuzzleException
     * @throws ForbiddenException
     */
    public function authorizeByTeam(int $userId, string $permission, string $team): void
    {
        $response = $this->client->request('GET', "/rbac/v1/users/$userId/check-permission", [
            'query' => ['permission_name' => $permission, 'team_names' => [$team]],
            'headers' => ['X-User' => $userId],
        ]);

        if ((new Response($response))->getStatusCode() !== Response::STATUS_CODE_OK) {
            throw new ForbiddenException('Forbidden');
        }
    }
}

<?php

namespace App\Campaign;

use GuzzleHttp\Client;

class MailchimpApiClient
{
    private $guzzle;
    private $apiKey;

    public function __construct(string $apiKey, string $baseUri)
    {
        $this->guzzle = new Client(['base_uri' => $baseUri]);
        $this->apiKey = $apiKey;
    }

    private function request($method, $uri, $body = null): array
    {
        $response = null;
        if ($body) {
            $response = $this->guzzle->request($method, $uri, [
                'auth' => [null, $this->apiKey],
                'json' => $body
            ]);
        } else {
            $response = $this->guzzle->request($method, $uri, [
                'auth' => [null, $this->apiKey]
            ]);
        }

        return json_decode($response->getBody()->getContents(), true);
    }

    public function createList(array $list): array
    {
        return $this->request('POST', 'lists', $list);
    }

    public function updateList(string $listId, array $list): array
    {
        return $this->request('PATCH', 'lists/'.$listId, $list);
    }

    public function removeList(string $listId): array
    {
        return $this->request('DELETE', 'lists/'.$listId);
    }

    public function addNewListMember(string $listId, array $member): array
    {
        return $this->request('POST', 'lists/'.$listId.'/members', $member);
    }

    public function updateListMember(string $listId, string $subscriberHash, array $member): array
    {
        return $this->request('PATCH', 'lists/'.$listId.'/members/'.$subscriberHash, $member);
    }

    public function deleteListMember(string $listId, string $subscriberHash): array
    {
        return $this->request('DELETE', 'lists/'.$listId.'/members/'.$subscriberHash);
    }
}

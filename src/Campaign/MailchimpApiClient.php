<?php

namespace App\Campaign;

use GuzzleHttp\Client;

class MailchimpApiClient
{
    const BASE_URI = 'https://us15.api.mailchimp.com/3.0/';
    private $guzzle;
    private $apiKey;

    public function __construct(string $apiKey)
    {
        $this->guzzle = new Client(['base_uri' => static::BASE_URI]);
        $this->apiKey = $apiKey;
    }

    private function request($method, $uri, $body = null)
    {
        $response = null;
        if ($body) {
            $response = $this->guzzle->request($method,$uri, [
                'auth' => [null, $this->apiKey],
                'json' => $body
            ]);
        } else {
            $response = $this->guzzle->request($method,$uri, [
                'auth' => [null, $this->apiKey]
            ]);
        }

        return json_decode($response->getBody()->getContents(), true);
    }

    public function createList(array $list)
    {
        return $this->request('POST', 'lists', $list);
    }

    public function updateList(string $listId, array $list)
    {
        return $this->request('PATCH', 'lists/'.$listId, $list);
    }

    public function removeList(string $listId)
    {
        return $this->request('DELETE', 'lists/'.$listId);
    }

    public function addNewListMember(string $listId, array $member)
    {
        return $this->request('POST', 'lists/'.$listId.'/members', $member);
    }

    public function updateListMember(string $listId, string $subscriberHash, array $member)
    {
        return $this->request('PATCH', 'lists/'.$listId.'/members/'.$subscriberHash, $member);
    }

    public function deleteListMember(string $listId, string $subscriberHash)
    {
        return $this->request('DELETE', 'lists/'.$listId.'/members/'.$subscriberHash);
    }
}
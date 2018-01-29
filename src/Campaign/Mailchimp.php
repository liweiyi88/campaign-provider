<?php

namespace App\Campaign;

use App\Entity\CampaignList;
use App\Entity\Member;

class Mailchimp implements CampaignInterface
{
    private $apiClient;

    public function __construct(MailchimpApiClient $apiClient)
    {
        $this->apiClient = $apiClient;
    }

    public function createList(CampaignList $list): ?array
    {
        return $this->apiClient->createList($list->toArray());
    }

    public function updateList(CampaignList $list): ?array
    {
        return $this->apiClient->updateList($list->getListId(), $list->toArray());
    }

    public function removeList(CampaignList $list): ?array
    {
        return $this->apiClient->removeList($list->getListId());
    }

    public function addMember(Member $member, CampaignList $list): ?array
    {
        return $this->apiClient->addNewListMember($list->getListId(), $member->toArray());
    }

    public function updateMember(Member $member, CampaignList $list): ?array
    {
        return $this->apiClient->updateListMember($list->getListId(), $member->getSubscriberHash(), $member->toArray());
    }

    public function removeMember(Member $member, CampaignList $list): ?array
    {
        return $this->apiClient->deleteListMember($list->getListId(), $member->getSubscriberHash());
    }
}

<?php

namespace App\Campaign;

use App\Entity\CampaignList;
use App\Entity\Member;

interface CampaignInterface
{
    public function createList(CampaignList $list): ?array;
    public function updateList(CampaignList $list): ?array;
    public function removeList(CampaignList $list): ?array;
    public function addMember(Member $member, CampaignList $list): ?array;
    public function updateMember(Member $member, CampaignList $list): ?array;
    public function removeMember(Member $member, CampaignList $list): ?array;
}

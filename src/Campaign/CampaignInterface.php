<?php

namespace App\Campaign;

use App\Entity\CampaignList;
use App\Entity\Member;

interface CampaignInterface
{
    public function createList(CampaignList $list);
    public function updateList(CampaignList $list);
    public function removeList(CampaignList $list);
    public function addMember(Member $member, CampaignList $list);
    public function updateMember(Member $member, CampaignList $list);
    public function removeMember(Member $member, CampaignList $list);
}
<?php

namespace App\Command;

use App\Campaign\Mailchimp;
use App\Entity\CampaignList;
use App\Entity\Member;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class AddMemberCommand extends Command
{
    protected static $defaultName = 'add:member';
    private $entityManager;
    private $mailchimp;

    public function __construct(EntityManagerInterface $entityManager, Mailchimp $mailchimp)
    {
        $this->entityManager = $entityManager;
        $this->mailchimp = $mailchimp;

        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setDescription('Add a member to a list')
            ->addOption('list_name', null, InputOption::VALUE_REQUIRED, '')
            ->addOption('email', null, InputOption::VALUE_REQUIRED, '')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $email = $input->getOption('email');
        $listName = $input->getOption('list_name');

        if ($email == null) {
            throw new \Exception('new_email option is required');
        }

        if ($listName == null) {
            throw new \Exception('list_name option is required');
        }

        $member = new Member();
        $member->setEmail($email);
        $member->setStatus(Member::STATUS_SUBSCRIBED);
        $list = $this->entityManager->getRepository(CampaignList::class)->findOneBy(['name' => $listName]);

        if (!$list) {
            throw new \Exception('List not found');
        }

        $response = $this->mailchimp->addMember($member, $list);
        $member->setSubscriberHash($response['id']);
        $member->setList($list);

        $this->entityManager->persist($member);
        $this->entityManager->flush();

        $io->success('A member has been added to a list');
    }
}

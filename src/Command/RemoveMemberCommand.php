<?php

namespace App\Command;

use App\Campaign\Mailchimp;
use App\Entity\Member;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class RemoveMemberCommand extends Command
{
    protected static $defaultName = 'remove:member';
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
            ->setDescription('Remove a member from a list')
            ->addOption('email', null, InputOption::VALUE_REQUIRED, 'Option description')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);

        $email = $input->getOption('email');
        $member = $this->entityManager->getRepository(Member::class)->findOneBy(['email' => $email]);

        if (!$member) {
            throw  new \Exception('Member not found');
        }

        $this->mailchimp->removeMember($member, $member->getList());
        $io->success('Member removed successfully');
    }
}

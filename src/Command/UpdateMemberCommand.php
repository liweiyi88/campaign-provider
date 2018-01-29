<?php

namespace App\Command;

use App\Campaign\Mailchimp;
use App\Entity\Member;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class UpdateMemberCommand extends Command
{
    protected static $defaultName = 'update:member';
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
            ->setDescription('Add a short description for your command')
            ->addOption('old_email', null, InputOption::VALUE_REQUIRED, 'Option description')
            ->addOption('new_email', null, InputOption::VALUE_REQUIRED, 'Option description')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);

        $oldEmail = $input->getOption('old_email');
        $newEmail = $input->getOption('new_email');

        if ($newEmail == null) {
            throw new \Exception('new_email option is required');
        }

        if ($oldEmail == null) {
            throw new \Exception('old_email option is required');
        }

        $member = $this->entityManager->getRepository(Member::class)->findOneBy(['email' => $oldEmail]);

        if (!$member) {
            throw new \Exception('Member not found');
        }

        $member->setEmail($newEmail);

        $response = $this->mailchimp->updateMember($member, $member->getList());
        $member->setSubscriberHash($response['id']);
        $this->entityManager->flush();

        $io->success('Member email has been updated');
    }
}

<?php

namespace App\Command;

use App\Campaign\Mailchimp;
use App\Entity\CampaignList;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class CreateListCommand extends Command
{
    protected static $defaultName = 'create:list';
    private $entityManager;
    private $mailchimp;

    public function __construct(Mailchimp $mailchimp, EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->mailchimp = $mailchimp;
        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setDescription('Create a mailchimp list')
            ->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
            ->addOption('name', null, InputOption::VALUE_REQUIRED, '')
            ->addOption('company', null, InputOption::VALUE_REQUIRED, '')
            ->addOption('address1', null, InputOption::VALUE_REQUIRED, '')
            ->addOption('city', null, InputOption::VALUE_REQUIRED, '')
            ->addOption('state', null, InputOption::VALUE_REQUIRED, '')
            ->addOption('zip', null, InputOption::VALUE_REQUIRED, '')
            ->addOption('country', null, InputOption::VALUE_REQUIRED, '')
            ->addOption('permission_reminder', null, InputOption::VALUE_REQUIRED, '')
            ->addOption('from_name', null, InputOption::VALUE_REQUIRED, '')
            ->addOption('from_email', null, InputOption::VALUE_REQUIRED, '')
            ->addOption('subject', null, InputOption::VALUE_REQUIRED, '')
            ->addOption('language', null, InputOption::VALUE_REQUIRED, '')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $list = new CampaignList();

        $list->setName($input->getOption('name'));
        $list->setCompany($input->getOption('company'));
        $list->setAddress1($input->getOption('address1'));
        $list->setCity($input->getOption('city'));
        $list->setState($input->getOption('state'));
        $list->setZip($input->getOption('zip'));
        $list->setCountry($input->getOption('country'));
        $list->setPermissionReminder($input->getOption('permission_reminder'));
        $list->setFromName($input->getOption('from_name'));
        $list->setFromEmail($input->getOption('from_email'));
        $list->setSubject($input->getOption('subject'));
        $list->setLanguage($input->getOption('language'));
        $list->setEmailTypeOption(false);

        $response = $this->mailchimp->createList($list);
        $list->setListId($response['id']);

        $this->entityManager->persist($list);
        $this->entityManager->flush();

        $io->success('List has been created');
    }
}

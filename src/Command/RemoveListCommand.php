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

class RemoveListCommand extends Command
{
    protected static $defaultName = 'remove:list';
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
            ->setDescription('Remove a mailchimp list')
            ->addOption('name', null, InputOption::VALUE_REQUIRED, '')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $name = $input->getOption('name');

        if ($name == null) {
            throw new \Exception('name option is required');
        }

        $list = $this->entityManager->getRepository(CampaignList::class)->findOneBy(['name' => $name]);
        $this->mailchimp->removeList($list);
        $this->entityManager->remove($list);
        $this->entityManager->flush();

        $io->success('List has been removed');
    }
}

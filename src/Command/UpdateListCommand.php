<?php

namespace App\Command;

use App\Campaign\Mailchimp;
use App\Entity\CampaignList;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class UpdateListCommand extends Command
{
    protected static $defaultName = 'update:list';
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
            ->setDescription('Update mailchimp list')
            ->addOption('old_name', null, InputOption::VALUE_REQUIRED, '')
            ->addOption('new_name', null, InputOption::VALUE_REQUIRED, '')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);

        $oldName = $input->getOption('old_name');
        $newName = $input->getOption('new_name');

        if ($oldName == null) {
            throw new \Exception('old_name option is required');
        }

        if ($newName == null) {
            throw new \Exception('new_name option is required');
        }

        $list = $this->entityManager->getRepository(CampaignList::class)->findOneBy(['name' => $oldName]);

        if ($list) {
            $list->setName($newName);
            $this->mailchimp->updateList($list);
            $this->entityManager->flush();

            $io->success('List has been updated');
        } else {
            $io->error('List '.$oldName.' not found');
        }
    }
}

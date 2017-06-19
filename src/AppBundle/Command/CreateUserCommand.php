<?php

namespace AppBundle\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
//use Psr\Log\LoggerInterface;

class CreateUserCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        /*$this
            // the name of the command (the part after "bin/console")
            ->setName('app:user')

            // the short description shown while running "php bin/console list"
            ->setDescription('Creates a new user.')

            // the full command description shown when running the command with
            // the "--help" option
            ->setHelp('This command allows you to create a user...')
            ->addArgument('name', InputArgument::REQUIRED, 'The username of the user.')
            ->addArgument('yell', InputArgument::OPTIONAL, true)
        ;*/

        $this
            ->setName('app:user')
            ->setDescription('Greet someone')
            ->addOption(
                'name',
                '-nn',
                InputOption::VALUE_REQUIRED,
                'Who do you want to greet?'
            )
        ;

        /*
        $defaultName = $this->defaultName;

        $this
            ->setName('app:user')
            ->setDescription('Greet someone')
            ->addOption(
                'name',
                '-n',
                InputOption::VALUE_REQUIRED,
                'Who do you want to greet?',
                $defaultName
            )
        ;*/
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $logger = $this->getContainer()->get('logger');

        $name = $input->getArgument('name');
        if ($name) {
            $text = 'Hello '.$name;
        } else {
            $text = 'Hello';
        }

        if ($input->getOption('yell')) {
            $text = strtoupper($text);
            $logger->warning('Yelled: '.$text);
        } else {
            $logger->info('Greeted: '.$text);
        }

        $output->writeln($text);
    }


}
<?php
namespace SqlPdo\Console;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class SqlpdoCommand extends Command {
    protected function configure()
    {
        $this
            ->setName('open')
            ->setDescription('Open connection to the database.')
            ->addArgument(
                'con',
                InputArgument::REQUIRED,
                'Connection name.'
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $con = $input->getArgument('con');

        $output->writeln($con);
    }
}

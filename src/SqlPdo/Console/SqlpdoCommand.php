<?php
namespace SqlPdo\Console;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use SqlPdo\Helper\Configuration;

class SqlpdoCommand extends Command {
    protected function configure()
    {
        $this
            ->setName('open')
            ->setDescription('Open connection to the database.')
            ->addArgument(
                'con',
                InputArgument::OPTIONAL,
                'Connection name.'
            )
        ;
    }

    protected function initialize()
    {
        if (empty(self::getAskList()))
            throw new \RuntimeException('Not found configuration file.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $dialog = $this->getHelper('dialog');
        $listPDO = self::getAskList();

        $list = $dialog->select($output, 'Please select your connection:', $listPDO, 0);
        $output->writeln('You have just selected: '.$listPDO[$list]);
    }

    private function getAsklist()
    {
        $conns = array();
        $connPDO = Configuration::getConfig('pdo');

        if (count($connPDO) > 0) {
            foreach ($connPDO as $conn) {
                $conns[] = $conn['nome'];
            }
        }

        return $conns;
    }
}

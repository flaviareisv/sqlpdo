<?php
namespace SqlPdo\Console;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use SqlPdo\Helper\Configuration;
use SqlPdo\Helper\Database;

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
        if (empty($this->getAskList()))
            throw new \RuntimeException('Not found configuration file.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $dialog = $this->getHelper('dialog');
        $listPDO = $this->getAskList();

        $listItem = $dialog->select($output, 'Please select your connection:', $listPDO, 0);
        $nameCon = $listPDO[$listItem];

        $output->writeln('You have just selected: '.$nameCon);

        $con = $this->conn($nameCon);
        $output->writeln(var_dump($con));
        //$st = $con->query('select * from user');
        //$output->writeln(var_dump($st));

        if ($con) {
            
        }
        else throw new \RuntimeException('An unexpected error occurred.');
    }

    private function getAsklist()
    {
        $conns = array();
        $connPDO = Configuration::getConfig('pdo');

        if (count($connPDO) > 0) {
            foreach ($connPDO as $conn) {
                //$conns[] = $conn['nome'].(!empty($conn['descricao']) ? ' ('.$conn['descricao'].')' : '');
                $conns[] = $conn['nome'];
            }
        }

        return $conns;
    }

    private function conn($nameCon) {
        $db = new Database($nameCon);
        $con = $db->getConn();

        return $con;
    }
}

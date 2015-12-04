<?php
namespace SqlPdo\Console;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use SqlPdo\Helper\Configuration;
use SqlPdo\Helper\Database;
use SqlPdo\Console\SqlCommand;

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

        $output->writeln('Welcome SqlPdo '.APP_VERSION);
        $output->writeln('');
        $listItem = $dialog->select($output, 'Please select your connection:', $listPDO, 0);

        $conf = new Configuration();
        $conf->setNameCon($listPDO[$listItem]);
        $isCon = $this->isDBCon($conf);

        if ($isCon) {
            $dataDB = $conf->getConfigDB();
        
            $output->writeln('');
            $output->writeln('Type \h for help');
            $output->writeln('');
            $output->writeln('Database: '.$dataDB['dbname']);
            $output->writeln('');

            $run = true;
            while ($run) {
                $bundle = SqlCommand::lineCmd($input, $output, $conf);
                $cmds = SqlCommand::getCmd($bundle);

                if ($bundle == '\h') {
                    SqlCommand::helpCommands($output);
                }
                elseif ($cmds) {
                    SqlCommand::executeCmdPDO($output, $bundle);
                }
                else SqlCommand::executeSQL($output, $bundle, $conf);
            }
        }
    }

    private function getAsklist()
    {
        $conns = array();
        $connPDO = Configuration::getConfig('pdo');

        if (count($connPDO) > 0) {
            foreach ($connPDO as $conn) {
                $conns[] = $conn['name'];
            }
        }

        return $conns;
    }

    private function isDBCon(Configuration $conf)
    {
        $db = new Database();
        $isCon = $db->isEstablished($conf);

        return $isCon;
    }

}

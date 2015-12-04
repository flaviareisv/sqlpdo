<?php
namespace SqlPdo\Console;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Helper\Table;
use SqlPdo\Helper\Database;
use SqlPdo\Helper\Configuration;

class SqlCommand 
{
    function sqlpdoCommands($cmd = null)
    {
        $cmds = array(
            'begin'    => 'Start a new transaction',
            'commit'   => 'Commits the current transaction, making its changes permanent',
            'rollback' => 'Rolls back the current transaction, canceling its changes',
            'quit'     => 'Quit SqlPdo.',
        );

        return $cmds;
    }

    function getCmd($cmd)
    {
        $cmds = self::sqlpdoCommands();
         
        if (array_key_exists($cmd, $cmds) !== false)
            return true;

        return false;
    }

    function lineCmd(InputInterface $input, OutputInterface $output, Configuration $conf)
    {
        $driver = self::getCmdDriver($conf);

        $helper = $this->getHelper('question');
        $question = new Question($driver);
        $bundle = $helper->ask($input, $output, $question);

        return $bundle;
    }

    function helpCommands(OutputInterface $output)
    {
        $output->writeln('');
        $output->writeln('For information about SqlPdo, visit:');
        $output->writeln('');
        $output->writeln(SITE_SQLPDO);
        $output->writeln('');
        $output->writeln('List of all SqlPdo commands:');
        $output->writeln('');

        $cmds = self::sqlpdoCommands();
        foreach ($cmds as $key => $desc) {
            $array[] = array($key.'   ', $desc);
        }

        $table = new Table($output);
        $table->setHeaders(array('',''))->setRows($array);
        $table->setStyle('compact');
        $table->render();
    }

    function executeCmdPDO(OutputInterface $output, $cmd)
    {
        $cmds = array_keys(self::sqlpdoCommands());

        if (array_search($cmd, $cmds) !== false) {
            switch ($cmd) {
                case 'quit':
                    $output->writeln('Bye');
                    exit();
                    break;
            } 
        }
    }

    function executeSQL(OutputInterface $output, $inSQL, Configuration $conf)
    {
        $conn = self::conn($conf);
        $time = microtime(true);

        $st = $conn->query($inSQL);
        $numRows = $st->rowCount();

        if ($numRows > 0) {
            $time = sprintf("%.6f", microtime(true) - $time);
            $rows = $st->fetchAll();
            $headers = array_keys($rows[0]);

            $table = new Table($output);
            $table->setHeaders($headers)->setRows($rows);
            $table->render();
        }

        // footer
        $output->writeln('Affected rows: '.$numRows.'    Timing: '.$time);
        $output->writeln('');
    }

    private function conn(Configuration $conf) {
        $db = new Database();
        $con = $db->getConn($conf);

        return $con;
    }


    private function getCmdDriver(Configuration $conf)
    {
        $cmdDriver = "sql> ";
        $drivers = array(
            'pdo_mysql' => 'mysql> ',
            'drizzle_pdo_mysql' => 'mysql> ',
            'mysqli' => 'mysql> ',
            'pdo_sqlite' => 'sqlite> ',
            'pdo_pgsql' => 'psql> ',
            'pdo_oci' => 'ora> ',
            'oci8' => 'ora> ',
        );

        $cfg = $conf->getConfigDB();
        $driver = $cfg['driver'];

        if (array_key_exists($driver, $drivers) !== false)
            $cmdDriver = $drivers[$driver];

        return $cmdDriver;
    }
    
}

<?php
namespace SqlPdo\Console;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Helper\Table;
use SqlPdo\Helper\Database;

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

    function lineCmd(InputInterface $input, OutputInterface $output)
    {
        $helper = $this->getHelper('question');
        $question = new Question('SQL > ');
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

    function executeCmd(OutputInterface $output, $cmd)
    {
        if ($cmd == 'quit') {
            $output->writeln('Bye');
            exit();
        }
    }

    function executeSQL(OutputInterface $output, $name, $outSQL)
    {
        $conn = self::conn($name);

        $st = $conn->query($outSQL);
        $numRows = $st->rowCount();

        if ($numRows > 0) {
            $rows = $st->fetchAll();
            $headers = array_keys($rows[0]);

            $table = new Table($output);
            $table->setHeaders($headers)->setRows($rows);
            $table->render();
        }

        // footer
        $output->writeln('Num rows: '.$numRows);
        $output->writeln('');
    }

    private function conn($nameCon) {
        $db = new Database($nameCon);
        $con = $db->getConn();

        return $con;
    }
    
}

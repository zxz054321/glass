<?php
/**
 * Author: Abel Halo <zxz054321@163.com>
 */

namespace App\Console;

use App\Foundation\Migration;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ConfirmationQuestion;

class Migrate extends Command
{
    protected function configure()
    {
        $this
            ->setName('migrate')
            ->setDescription('Database migration');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        if (!config('app.debug')) {
            $helper   = $this->getHelper('question');
            $question = new ConfirmationQuestion(
                "Application May In Production!\n".
                'Do you really wish to run this command?',
                false
            );

            if (!$helper->ask($input, $output, $question)) {
                return;
            }
        }

        $migrations = config('database.migrations');

        foreach ($migrations as $migration) {
            /** @noinspection PhpIncludeInspection */
            require ROOT."/database/migrations/$migration.php";

            $class = ucwords($migration);
            $class = str_replace('_', '', $class);
            $class = "Create{$class}Table";

            /** @var Migration $table */
            $table = new $class;

            $table->down();
            $table->up();

            $output->writeln('Migrated: '.$migration);
        }
    }
}
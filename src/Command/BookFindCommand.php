<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class BookFindCommand extends Command
{
    protected static $defaultName = 'app:book:find';
    protected static $defaultDescription = 'Add a short description for your command';

    protected function configure(): void
    {
        $this
            ->addArgument('lastname', InputArgument::OPTIONAL, 'Argument description')
            ->addArgument('firstname', InputArgument::OPTIONAL|InputArgument::IS_ARRAY, 'Argument description')
            ->addOption('option1', 'o', InputOption::VALUE_NONE, 'Option description')
            ->addOption('option2', 'b', InputOption::VALUE_NONE, 'Option description')
            ->addOption('negatable', null, InputOption::VALUE_NEGATABLE, 'Negatable option')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $arg1 = $input->getArgument('firstname');

        if ($arg1) {
            $io->note(sprintf('You passed firstname: %s', implode(', ', $arg1)));
        }

        $arg2 = $input->getArgument('lastname');

        if ($arg2) {
            $io->note(sprintf('You passed lastname: %s', $arg2));
        }

        if ($input->getOption('option1')) {
            $io->note('You passed an option');
        }

        if ($input->getOption('option2')) {
            $io->note('You passed a second option');
        }

        $opt = $input->getOption('negatable');
        if (null !== $opt) {
            if($opt === true) {
                $display = 'True';
            } elseif ($opt === false) {
                $display = 'False';
            } else {
                $display = 'Foo';
            }
            $io->note(sprintf("Negatable Option passed as : %s", $display));
        }

        $io->success('You have a new command! Now make it your own! Pass --help to see your options.');

        return Command::SUCCESS;
    }
}

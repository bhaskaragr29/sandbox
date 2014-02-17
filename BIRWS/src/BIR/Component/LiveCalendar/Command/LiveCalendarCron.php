<?php

namespace BIR\Component\LiveCalendar\Command;

/**
 *
 * @author Bhaskar Agarwal <bhaskar.agarwal@paddypower.com>
 *         @created Feb 17, 2014 - 10:32:42 AM
 *         @encoding UTF-8
 */
use BIR\Component\LiveCalendar\Repositry\LiveCalendarRepositry;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class LiveCalendarCron extends Command {
	protected $database;
	
	/**
	 *
	 * @param $database @codeCoverageIgnore        	
	 */
	public function setDatabase($database) {
		$this->database = $database;
	}
	protected function configure() {
		$this->setName ( 'housecleaning' )->setDescription ( 'House Cleaning of DB' );
	}
	
	/**
	 *
	 * @param InputInterface $input        	
	 * @param OutputInterface $output        	
	 * @return int null void
	 */
	protected function execute(InputInterface $input, OutputInterface $output) {
		$liveRepo = new LiveCalendarRepositry ( $this->database );
		$liveRepo->deleteLast24Hours ();
		$output->writeln ( 'Operation complete!' );
	}
}

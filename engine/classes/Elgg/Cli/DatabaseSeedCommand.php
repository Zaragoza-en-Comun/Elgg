<?php

namespace Elgg\Cli;

use Symfony\Component\Console\Input\InputOption;

/**
 * elgg-cli database:seed
 */
class DatabaseSeedCommand extends Command {

	/**
	 * {@inheritdoc}
	 */
	protected function configure() {
		$this->setName('database:seed')
			->addOption('limit', 'l', InputOption::VALUE_OPTIONAL, 'Number of entities to seed')
			->setDescription('Seeds the database with fake entities');
	}

	/**
	 * {@inheritdoc}
	 */
	protected function command() {

		if (!class_exists('\Faker\Generator')) {
			elgg_log('This is a developer tool currently intended for testing purposes only. Please refrain from using it.', 'ERROR');

			return 1;
		}

		set_time_limit(0);

		if (elgg_is_logged_in()) {
			elgg_log("Seeds should not be run with a logged in user", 'ERROR');

			return 2;
		}

		_elgg_services()->setValue('mailer', new \Zend\Mail\Transport\InMemory());

		$limit = $this->option('limit') ? : 20;
		try {
			_elgg_services()->seeder->seed($limit);
		} catch (\Exception $e) {
			elgg_log($e->getMessage(), 'ERROR');

			return $e->getCode() ? : 3;
		}
	}

}
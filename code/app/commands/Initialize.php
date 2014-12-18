<?php namespace App\Command;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;

class Initialize extends Command
{

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'app:initialize';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Initialize the application.';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return void
	 */
	public function fire()
	{
		if ($this->confirm('Do you wish to continue? [yes|no]', true)) {
			$this->info('');
			$this->info('Reseting DB...');
			$this->call('migrate:reset');

			$this->info('');
			// Add your packages here
			// $this->info('Migrating Sentry Package...');
			// $this->call('migrate', array('--package' => 'cartalyst/sentry'));

			$this->info('');
			$this->info('Refreshing DB...');
			$this->call('migrate');

			if ($this->option('seed')) {
				$this->info('');
				$this->info('Seeding DB...');
				$this->call('db:seed');
			}

			$this->info('');
			$this->info('Done!');
			$this->info('');
		} else {
			$this->error('Initialize was stopped by the user.');
		}
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return array();
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions()
	{
		return array(array('seed', 's', InputOption::VALUE_NONE, 'Determine if the DB will be seeded.', null));
	}

}

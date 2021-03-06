<?php

namespace InExtenso\CUA;

use Symfony\Component\Console\Application;
use InExtenso\CUA\Command\CheckCommand;
use InExtenso\CUA\Configuration\MainConfiguration;
use Symfony\Component\Config\Definition\Processor;
use Symfony\Component\Console\Input\ArgvInput;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Console\Output\ConsoleOutputInterface;
use Symfony\Component\Yaml\Yaml;

class CuaApplication extends Application
{
    private $config;

    private $persistance;

    private $results;

    public function __construct()
    {
        parent::__construct('Composer Update Analyser', '1.0.0-alpha-3');
        $this->add(new CheckCommand());
    }

    /**
     * Runs the current application.
     *
     * @param InputInterface  $input  An Input instance
     * @param OutputInterface $output An Output instance
     *
     * @return int 0 if everything went fine, or an error code
     *
     * @throws \Exception When doRun returns Exception
     */
    public function run(InputInterface $input = null, OutputInterface $output = null)
    {
        if (null === $input) {
            $input = new ArgvInput();
        }

        if (null === $output) {
            $output = new ConsoleOutput();
        }

        $this->configureIO($input, $output);

        try {
            $this->boot($input);
        } catch (\Exception $e) {
            if ($output instanceof ConsoleOutputInterface) {
                $this->renderException($e, $output->getErrorOutput());
            } else {
                $this->renderException($e, $output);
            }

            $exitCode = $e->getCode();
            if (is_numeric($exitCode)) {
                $exitCode = (int) $exitCode;
                if (0 === $exitCode) {
                    $exitCode = 1;
                }
            } else {
                $exitCode = 1;
            }
            exit($exitCode);
        }

        return parent::run($input, $output);
    }

    public function getProjects()
    {
        return $this->config['projects'];
    }

    public function setProjectResult($projectName, array $content)
    {
        $this->results[$projectName] = $content;
    }

    public function saveResult($path = null)
    {
        $this->persistance->save($this->results, $path);

        //$content = Yaml::dump($this->results, 100);
        //file_put_contents(($path !== null)? $path:$this->config['output'], $content);
    }

    public function getComposerPath()
    {
        return $this->config['composer_path'];
    }

    public function definePersistance($name, $parameters)
    {
        $className = 'InExtenso\\CUA\\Persistence\\'.$name;
        if (!class_exists($className)) {
            throw new \Exception('Unable to load this persistance class: '.$className, 1);
        }
        $this->persistance = new $className($parameters);
    }

    /**
     * Gets the default input definition.
     *
     * @return InputDefinition An InputDefinition instance
     */
    protected function getDefaultInputDefinition()
    {
        $input = parent::getDefaultInputDefinition();
        $input->addOption(new InputOption('--no-config', null, InputOption::VALUE_NONE, 'Do not load the configuration'));

        return $input;
    }

    /**
     * This function run the first level booting.
     */
    private function boot(InputInterface $input)
    {
        $this->config = ['output' => null, 'projects' => [], 'composer_path' => null];
        if (!$input->hasParameterOption(['--no-config'], true)) {
            $configFile = __DIR__.'/cua.yml';
            $this->loadConfigurationFile($configFile);

            $this->definePersistance($this->config['persistance']['format'], $this->config['persistance']['parameters']);
        }
    }

    /**
     * Load the configuration file.
     */
    private function loadConfigurationFile($configFile)
    {
        if (!file_exists($configFile)) {
            throw new \Exception('Le fichier de configuration ($configFile) est absent ! ', 123);
        }

        $config = Yaml::parse(file_get_contents($configFile));

        $configs = [$config];
        $processor = new Processor();
        $configuration = new MainConfiguration();
        $this->config = $processor->processConfiguration($configuration, $configs);
    }
}

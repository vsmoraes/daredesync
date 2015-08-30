<?php

namespace Sync\Command;

use Sync\App;
use Sync\Otrs\Repository\CustomerCompany;
use Sync\Pipedrive\Request;
use Sync\Pipedrive\Repository\Organization;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Sync\Support\Entity;

class ImportFromPipedrive extends Command
{
    private $otrsCompanyRepo;

    public function __construct(CustomerCompany $otrsCompanyRepo)
    {
        $this->otrsCompanyRepo = $otrsCompanyRepo;

        parent::__construct(null);
    }

    /**
     * Command definition
     */
    protected function configure()
    {
        $this->setName('sync:fromPipedrive')
            ->setDescription('Import data from the Pipedrive into the database');
    }

    /**
     * Send messages to the console
     *
     * @param Entity $entity
     * @param OutputInterface $output
     * @param $message
     * @param string $style
     */
    private function message(Entity $entity, OutputInterface $output, $message, $style = 'info')
    {
        $formatter = $this->getHelper('formatter');
        $formatedLine = $formatter->formatSection(
            $entity->getName(),
            $message,
            $style
        );

        $output->writeln($formatedLine);
    }

    /**
     * Command logic
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $org_repo = new Organization(App::getInstance()->resolve(Request::class));

        $org_collection = $org_repo->all();
        foreach ($org_collection as $org) {
            $this->updateOtrs($org, $output);
        }
    }

    /**
     * Update the entity with data from pipedrive
     *
     * @param Entity $fromPipedrive
     * @param OutputInterface $output
     * @return bool
     */
    protected function updateOtrs(Entity $fromPipedrive, OutputInterface $output)
    {
        if (! $fromPipedrive->getTaxId()) {
            $this->message($fromPipedrive, $output, 'No tax_id on Pipedrive', 'error');

            return false;
        }

        $toOtrs = $this->getCustomerCompany($fromPipedrive->getTaxId());
        $toOtrs->fill($fromPipedrive->toArray());

        if (! $toOtrs->isDirty()) {
            $this->message($fromPipedrive, $output, 'Nothing to update', 'comment');

            return false;
        }

        $this->message($fromPipedrive, $output, 'Updating...');
        $this->otrsCompanyRepo->update($toOtrs);
    }

    /**
     * Retrive the company from the repository
     *
     * @param $tax_id
     * @return mixed
     * @throws \Exception
     */
    protected function getCustomerCompany($tax_id)
    {
        return $this->otrsCompanyRepo->findByTaxId($tax_id);
    }
}

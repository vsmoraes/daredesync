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
    /**
     * Command definition
     */
    protected function configure()
    {
        $this->setName('sync:fromPipedrive')
            ->setDescription('Import data from the Pipedrive into the database');
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
            $this->updateOtrs($org);
//            $output->writeln('Organization: ' . $org->getTaxId() . ' name: ' . $organization->getName());
        }
    }

    protected function updateOtrs(Entity $fromPipedrive)
    {
        if (! $fromPipedrive->getTaxId()) {
            return false;
        }

        var_dump($fromPipedrive->toArray());die();

        $toOtrs = $this->getCustomerCompany($fromPipedrive->getTaxId());
        $toOtrs->fill($fromPipedrive);

        var_dump($toOtrs->getDirty());
        die();
    }

    protected function getCustomerCompany($tax_id)
    {
        $repo = App::getInstance()->resolve(CustomerCompany::class);

        return $repo->findByTaxId($tax_id);
    }
}

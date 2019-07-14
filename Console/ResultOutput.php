<?php

declare(strict_types=1);

namespace Baldwin\UrlDataIntegrityChecker\Console;

use Magento\Framework\Console\Cli;
use Symfony\Component\Console\Helper\Table as ConsoleTable;
use Symfony\Component\Console\Output\OutputInterface;

class ResultOutput
{
    public function outputResult(array $productData, OutputInterface $output): int
    {
        if (empty($productData)) {
            $output->writeln('<info>No problems found!</info>');

            return Cli::RETURN_SUCCESS;
        }

        usort($productData, function ($prodA, $prodB) {
            if ($prodA['id'] === $prodB['id']) {
                return $prodA['storeId'] <=> $prodB['storeId'];
            }

            return $prodA['id'] <=> $prodB['id'];
        });

        $table = new ConsoleTable($output);
        $table->setHeaders(['ID', 'SKU', 'Store', 'Problem']);
        $table->setRows($productData);

        $table->render();

        return Cli::RETURN_FAILURE;
    }
}

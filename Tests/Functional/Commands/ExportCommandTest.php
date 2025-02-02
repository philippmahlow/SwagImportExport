<?php
declare(strict_types=1);
/**
 * (c) shopware AG <info@shopware.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SwagImportExport\Tests\Functional\Commands;

use PHPUnit\Framework\TestCase;
use SwagImportExport\Tests\Helper\CommandTestCaseTrait;
use SwagImportExport\Tests\Helper\DatabaseTestCaseTrait;
use SwagImportExport\Tests\Helper\FixturesImportTrait;

class ExportCommandTest extends TestCase
{
    use FixturesImportTrait;
    use CommandTestCaseTrait;
    use DatabaseTestCaseTrait;

    public function testArticlesCsvExportCommand(): void
    {
        $expectedLineAmount = 290;
        $profileName = 'default_articles';

        $fileName = 'article.csv';
        $this->addCreatedExportFile($fileName);

        $consoleOutput = $this->runCommand(sprintf('sw:importexport:export -p %s %s', $profileName, $fileName));

        $fp = \file($this->getFilePath($fileName));
        $lineAmount = \count($fp);

        static::assertEquals('Using format: csv.', $consoleOutput[1]);
        static::assertEquals('Total count: 225.', $consoleOutput[3]);
        static::assertEquals($expectedLineAmount, $lineAmount, sprintf('Expected %s lines, found %s', $expectedLineAmount, $lineAmount));
    }

    public function testVariantsCsvExportCommand(): void
    {
        $expectedLineAmount = 525;
        $profileName = 'default_articles';

        $fileName = 'variants.csv';
        $this->addCreatedExportFile($fileName);

        $consoleOutput = $this->runCommand(sprintf('sw:importexport:export -p %s -x %s', $profileName, $fileName));

        $fp = \file($this->getFilePath($fileName));
        $lineAmount = \count($fp);

        static::assertEquals('Using format: csv.', $consoleOutput[1]);
        static::assertEquals('Total count: 400.', $consoleOutput[3]);
        static::assertEquals($expectedLineAmount, $lineAmount, sprintf('Expected %s lines, found %s', $expectedLineAmount, $lineAmount));
    }

    public function testCustomerCsvExportCommand(): void
    {
        $expectedLineAmount = 3;
        $profileName = 'default_customers_complete';

        $fileName = 'customer.csv';
        $this->addCreatedExportFile($fileName);

        $consoleOutput = $this->runCommand(sprintf('sw:importexport:export -p %s %s', $profileName, $fileName));

        $fp = \file($this->getFilePath($fileName));
        $lineAmount = \count($fp);

        static::assertEquals('Using format: csv.', $consoleOutput[1]);
        static::assertEquals('Total count: 2.', $consoleOutput[3]);
        static::assertEquals($expectedLineAmount, $lineAmount, sprintf('Expected %s lines, found %s', $expectedLineAmount, $lineAmount));
    }

    public function testCategoriesCsvExportCommand(): void
    {
        $expectedLineAmount = 65;
        $profileName = 'default_categories';

        $fileName = 'categories.csv';
        $this->addCreatedExportFile($fileName);

        $consoleOutput = $this->runCommand(sprintf('sw:importexport:export -p %s %s', $profileName, $fileName));

        $fp = \file($this->getFilePath($fileName));
        $lineAmount = \count($fp);

        static::assertEquals('Using format: csv.', $consoleOutput[1]);
        static::assertEquals('Total count: 62.', $consoleOutput[3]);
        static::assertEquals(
            $expectedLineAmount,
            $lineAmount,
            sprintf('Expected %s lines, found %s', $expectedLineAmount, $lineAmount)
        );
    }

    public function testArticlesInStockCsvExportCommand(): void
    {
        $expectedLineAmount = 405;
        $profileName = 'default_article_in_stock';

        $fileName = 'articlesinstock.csv';
        $this->addCreatedExportFile($fileName);

        $consoleOutput = $this->runCommand(sprintf('sw:importexport:export -p %s %s', $profileName, $fileName));

        $fp = \file($this->getFilePath($fileName));
        $lineAmount = \count($fp);

        static::assertEquals('Using format: csv.', $consoleOutput[1]);
        static::assertEquals('Total count: 400.', $consoleOutput[3]);
        static::assertEquals(
            $expectedLineAmount,
            $lineAmount,
            sprintf('Expected %s lines, found %s', $expectedLineAmount, $lineAmount)
        );
    }

    public function testArticlesPricesCsvExportCommand(): void
    {
        $expectedLineAmount = 406;
        $profileName = 'default_article_prices';

        $fileName = 'articlesprices.csv';
        $this->addCreatedExportFile($fileName);

        $consoleOutput = $this->runCommand(sprintf('sw:importexport:export -p %s %s', $profileName, $fileName));

        $fp = \file($this->getFilePath($fileName));
        $lineAmount = \count($fp);

        static::assertEquals('Using format: csv.', $consoleOutput[1]);
        static::assertEquals('Total count: 405.', $consoleOutput[3]);
        static::assertEquals(
            $expectedLineAmount,
            $lineAmount,
            sprintf('Expected %s lines, found %s', $expectedLineAmount, $lineAmount)
        );
    }

    public function testArticlesImagesCsvExportCommand(): void
    {
        $profileName = 'default_article_images';

        $fileName = 'articlesimage.csv';

        $this->expectException(\InvalidArgumentException::class);
        $this->runCommand(sprintf('sw:importexport:export -p %s %s', $profileName, $fileName));
    }

    public function testArticlesTranslationsCsvExportCommand(): void
    {
        $profileName = 'default_article_translations_update';

        $fileName = 'articlestranslation.csv';
        $this->addCreatedExportFile($fileName);

        $consoleOutput = $this->runCommand(sprintf('sw:importexport:export -p %s %s', $profileName, $fileName));

        static::assertEquals('Using format: csv.', $consoleOutput[1]);
        static::assertEquals('Total count: 225.', $consoleOutput[3]);
    }

    public function testOrderCsvExportCommand(): void
    {
        $expectedLineAmount = 18;
        $profileName = 'default_orders_minimal';

        $fileName = 'order.csv';
        $this->addCreatedExportFile($fileName);

        $consoleOutput = $this->runCommand(sprintf('sw:importexport:export -p %s %s', $profileName, $fileName));

        $fp = \file($this->getFilePath($fileName));
        $lineAmount = \count($fp);

        static::assertEquals('Using format: csv.', $consoleOutput[1]);
        static::assertEquals('Total count: 17.', $consoleOutput[3]);
        static::assertEquals(
            $expectedLineAmount,
            $lineAmount,
            sprintf('Expected %s lines, found %s', $expectedLineAmount, $lineAmount)
        );
    }

    public function testMainOrderCsvExportCommand(): void
    {
        $expectedLineAmount = 5;
        $profileName = 'default_order_main_data';

        $fileName = 'mainorder.csv';
        $this->addCreatedExportFile($fileName);

        $consoleOutput = $this->runCommand(sprintf('sw:importexport:export -p %s %s', $profileName, $fileName));

        $fp = \file($this->getFilePath($fileName));
        $lineAmount = \count($fp);

        static::assertEquals('Using format: csv.', $consoleOutput[1]);
        static::assertEquals('Total count: 4.', $consoleOutput[3]);
        static::assertEquals(
            $expectedLineAmount,
            $lineAmount,
            sprintf('Expected %s lines, found %s', $expectedLineAmount, $lineAmount)
        );
    }

    public function testTranslationsCsvExportCommand(): void
    {
        $expectedLineAmount = 16;
        $profileName = 'default_system_translations';

        $fileName = 'translation.csv';
        $this->addCreatedExportFile($fileName);

        $consoleOutput = $this->runCommand(sprintf('sw:importexport:export -p %s %s', $profileName, $fileName));

        $fp = \file($this->getFilePath($fileName));
        $lineAmount = \count($fp);

        static::assertEquals('Using format: csv.', $consoleOutput[1]);
        static::assertEquals('Total count: 15.', $consoleOutput[3]);
        static::assertEquals(
            $expectedLineAmount,
            $lineAmount,
            sprintf('Expected %s lines, found %s', $expectedLineAmount, $lineAmount)
        );
    }

    public function testNewsletterCsvExportCommand(): void
    {
        $this->importNewsletterDemoData();

        $expectedLineAmount = 26;
        $profileName = 'default_newsletter_recipient';

        $fileName = 'newsletter.csv';
        $this->addCreatedExportFile($fileName);

        $consoleOutput = $this->runCommand(sprintf('sw:importexport:export -p %s %s', $profileName, $fileName));

        $fp = \file($this->getFilePath($fileName));
        $lineAmount = \count($fp);

        static::assertEquals('Using format: csv.', $consoleOutput[1]);
        static::assertEquals('Total count: 25.', $consoleOutput[3]);
        static::assertEquals(
            $expectedLineAmount,
            $lineAmount,
            sprintf('Expected %s lines, found %s', $expectedLineAmount, $lineAmount)
        );
    }

    public function testArticlesXmlExportCommandWithLimit(): void
    {
        $expectedLineAmount = 6462;
        $profileName = 'default_articles';

        $fileName = 'article.xml';
        $this->addCreatedExportFile($fileName);

        $consoleOutput = $this->runCommand(sprintf('sw:importexport:export -p %s -l 100 %s', $profileName, $fileName));

        $fp = \file($this->getFilePath($fileName));
        $lineAmount = \count($fp);

        static::assertEquals('Using format: xml.', $consoleOutput[1]);
        static::assertEquals('Total count: 100.', $consoleOutput[3]);
        static::assertEquals(
            $expectedLineAmount,
            $lineAmount,
            sprintf('Expected %s lines, found %s', $expectedLineAmount, $lineAmount)
        );
    }

    public function testVariantsXmlExportCommandWithLimit(): void
    {
        $expectedLineAmount = 6462;
        $profileName = 'default_articles';

        $fileName = 'variants.xml';
        $this->addCreatedExportFile($fileName);

        $consoleOutput = $this->runCommand(sprintf(
            'sw:importexport:export -p %s -l 100 -x %s',
            $profileName,
            $fileName
        ));

        $fp = \file($this->getFilePath($fileName));
        $lineAmount = \count($fp);

        static::assertEquals('Using format: xml.', $consoleOutput[1]);
        static::assertEquals('Total count: 100.', $consoleOutput[3]);
        static::assertEquals(
            $expectedLineAmount,
            $lineAmount,
            sprintf('Expected %s lines, found %s', $expectedLineAmount, $lineAmount)
        );
    }

    public function testCustomerXmlExportCommandWithLimit(): void
    {
        $expectedLineAmount = 43;
        $profileName = 'default_customers';

        $fileName = 'customer.xml';
        $this->addCreatedExportFile($fileName);

        $consoleOutput = $this->runCommand(sprintf('sw:importexport:export -p %s -l 1 %s', $profileName, $fileName));

        $fp = \file($this->getFilePath($fileName));
        $lineAmount = \count($fp);

        static::assertEquals('Using format: xml.', $consoleOutput[1]);
        static::assertEquals('Total count: 1.', $consoleOutput[3]);
        static::assertEquals(
            $expectedLineAmount,
            $lineAmount,
            sprintf('Expected %s lines, found %s', $expectedLineAmount, $lineAmount)
        );
    }

    public function testCategoriesXmlExportCommandWithLimit(): void
    {
        $expectedLineAmount = 208;
        $profileName = 'default_categories_minimal';

        $fileName = 'categories.xml';
        $this->addCreatedExportFile($fileName);

        $consoleOutput = $this->runCommand(sprintf('sw:importexport:export -p %s -l 40 %s', $profileName, $fileName));

        $fp = \file($this->getFilePath($fileName));
        $lineAmount = \count($fp);

        static::assertEquals('Using format: xml.', $consoleOutput[1]);
        static::assertEquals('Total count: 40.', $consoleOutput[3]);
        static::assertEquals(
            $expectedLineAmount,
            $lineAmount,
            sprintf('Expected %s lines, found %s', $expectedLineAmount, $lineAmount)
        );
    }

    public function testArticlesInStockXmlExportCommandWithLimit(): void
    {
        $expectedLineAmount = 1408;
        $profileName = 'default_article_in_stock';

        $fileName = 'articlesinstock.xml';
        $this->addCreatedExportFile($fileName);

        $consoleOutput = $this->runCommand(sprintf('sw:importexport:export -p %s -l 200 %s', $profileName, $fileName));

        $fp = \file($this->getFilePath($fileName));
        $lineAmount = \count($fp);

        static::assertEquals('Using format: xml.', $consoleOutput[1]);
        static::assertEquals('Total count: 200.', $consoleOutput[3]);
        static::assertEquals(
            $expectedLineAmount,
            $lineAmount,
            sprintf('Expected %s lines, found %s', $expectedLineAmount, $lineAmount)
        );
    }

    public function testArticlesPricesXmlExportCommandWithLimit(): void
    {
        $expectedLineAmount = 1208;
        $profileName = 'default_article_prices';

        $fileName = 'articlesprices.xml';
        $this->addCreatedExportFile($fileName);

        $consoleOutput = $this->runCommand(sprintf('sw:importexport:export -p %s -l 100 %s', $profileName, $fileName));

        $fp = \file($this->getFilePath($fileName));
        $lineAmount = \count($fp);

        static::assertEquals('Using format: xml.', $consoleOutput[1]);
        static::assertEquals('Total count: 100.', $consoleOutput[3]);
        static::assertEquals(
            $expectedLineAmount,
            $lineAmount,
            sprintf('Expected %s lines, found %s', $expectedLineAmount, $lineAmount)
        );
    }

    public function testArticlesImagesXmlExportCommandWithLimit(): void
    {
        $profileName = 'default_article_images';

        $fileName = 'articlesimage.xml';

        $this->expectException(\InvalidArgumentException::class);
        $this->runCommand(sprintf('sw:importexport:export -p %s -l 50 %s', $profileName, $fileName));
    }

    public function testArticlesTranslationsXmlExportCommandWithLimit(): void
    {
        $profileName = 'default_article_translations_update';

        $fileName = 'articlestranslation.xml';
        $this->addCreatedExportFile($fileName);

        $consoleOutput = $this->runCommand(sprintf('sw:importexport:export -p %s %s', $profileName, $fileName));

        static::assertEquals('Using format: xml.', $consoleOutput[1]);
        static::assertEquals('Total count: 225.', $consoleOutput[3]);
    }

    public function testMainOrderXmlExportCommandWithLimit(): void
    {
        $expectedLineAmount = 111;
        $profileName = 'default_order_main_data';

        $fileName = 'mainorder.xml';
        $this->addCreatedExportFile($fileName);

        $consoleOutput = $this->runCommand(sprintf('sw:importexport:export -p %s -l 2 %s', $profileName, $fileName));

        $fp = \file($this->getFilePath($fileName));
        $lineAmount = \count($fp);

        static::assertEquals('Using format: xml.', $consoleOutput[1]);
        static::assertEquals('Total count: 2.', $consoleOutput[3]);
        static::assertEquals(
            $expectedLineAmount,
            $lineAmount,
            sprintf('Expected %s lines, found %s', $expectedLineAmount, $lineAmount)
        );
    }

    public function testTranslationsXmlExportCommandWithLimit(): void
    {
        $expectedLineAmount = 88;
        $profileName = 'default_system_translations';

        $fileName = 'translation.xml';
        $this->addCreatedExportFile($fileName);

        $consoleOutput = $this->runCommand(sprintf('sw:importexport:export -p %s -l 10 %s', $profileName, $fileName));

        $fp = \file($this->getFilePath($fileName));
        $lineAmount = \count($fp);

        static::assertEquals('Using format: xml.', $consoleOutput[1]);
        static::assertEquals('Total count: 10.', $consoleOutput[3]);
        static::assertEquals(
            $expectedLineAmount,
            $lineAmount,
            sprintf('Expected %s lines, found %s', $expectedLineAmount, $lineAmount)
        );
    }

    public function testNewsletterXmlExportCommandWithLimit(): void
    {
        $this->importNewsletterDemoData();

        $expectedLineAmount = 230;
        $profileName = 'default_newsletter_recipient';

        $fileName = 'newsletter.xml';
        $this->addCreatedExportFile($fileName);

        $consoleOutput = $this->runCommand(sprintf('sw:importexport:export -p %s -l 15 %s', $profileName, $fileName));

        $fp = \file($this->getFilePath($fileName));
        $lineAmount = \count($fp);

        static::assertEquals('Using format: xml.', $consoleOutput[1]);
        static::assertEquals('Total count: 15.', $consoleOutput[3]);
        static::assertEquals(
            $expectedLineAmount,
            $lineAmount,
            sprintf('Expected %s lines, found %s', $expectedLineAmount, $lineAmount)
        );
    }
}

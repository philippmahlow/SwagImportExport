<?php
/**
 * (c) shopware AG <info@shopware.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SwagImportExport\Tests\Functional\Components\SwagImportExport\DbAdapters\Articles;

use Doctrine\DBAL\Connection;
use PHPUnit\Framework\TestCase;
use Shopware\Components\SwagImportExport\DbAdapters\Articles\PriceWriter;
use SwagImportExport\Tests\Helper\DatabaseTestCaseTrait;

class PriceWriterTest extends TestCase
{
    use DatabaseTestCaseTrait;

    public function testWriteThrowsExceptionIfEmptyValues()
    {
        $priceWriterDbAdapter = $this->createPriceWriterAdapter();

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Tax for article  not found');
        $priceWriterDbAdapter->write('', '', []);
    }

    public function testWriteThrowsExceptionIfPriceGroupNotExists()
    {
        $priceWriterDbAdapter = $this->createPriceWriterAdapter();

        $articlePriceData = [
            [
                'price' => '9,95',
                'priceGroup' => 'price_group_does_not_exist',
            ],
        ];
        $articleOrderNumber = 3;
        $articleId = 3;

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Kundengruppe mit Schlüssel price_group_does_not_exist nicht gefunden für Artikel SW10003.');
        $priceWriterDbAdapter->write($articleId, $articleOrderNumber, $articlePriceData);
    }

    public function testWriteThrowsExceptionIfPriceIsInvalid()
    {
        $priceWriterDbAdapter = $this->createPriceWriterAdapter();

        $articlePriceData = [
            [
                'price' => 'invalidPrice',
            ],
        ];
        $articleOrderNumber = 3;
        $articleId = 3;

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('price Feld muss float sein und nicht invalidPrice!');
        $priceWriterDbAdapter->write($articleId, $articleOrderNumber, $articlePriceData);
    }

    public function testWriteThrowsExceptionIfPriceFromIsInvalid()
    {
        $priceWriterDbAdapter = $this->createPriceWriterAdapter();

        $articlePriceData = [
            [
                'price' => '9,95',
                'from' => '-12',
            ],
        ];
        $articleOrderNumber = 3;
        $articleId = 3;

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Ungültiger von Wert im Preis für Artikel SW10003.');
        $priceWriterDbAdapter->write($articleId, $articleOrderNumber, $articlePriceData);
    }

    public function testWriteShouldUpdatePriceWithDotSeperation()
    {
        $priceWriterAdapter = $this->createPriceWriterAdapter();

        $articlePriceData = [
            [
                'price' => '9.95',
                'priceGroup' => 'EK',
            ],
        ];
        $articleOrderNumber = 3;
        $articleId = 3;
        $expectedArticlePrice = 8.3613445378151;

        $priceWriterAdapter->write($articleId, $articleOrderNumber, $articlePriceData);

        /** @var Connection $dbalConnection */
        $dbalConnection = Shopware()->Container()->get('dbal_connection');
        $updatedArticle = $dbalConnection->executeQuery("SELECT * FROM s_articles_prices WHERE articleID='{$articleId}'")->fetchAll();

        static::assertEquals($expectedArticlePrice, $updatedArticle[0]['price']);
    }

    public function testWriteShouldUpdateArticlePrice()
    {
        $priceWriterAdapter = $this->createPriceWriterAdapter();

        $articlePriceData = [
            [
                'price' => '9,95',
                'priceGroup' => 'EK',
            ],
        ];
        $articleOrderNumber = 3;
        $articleId = 3;
        $expectedArticlePrice = 8.3613445378151;

        $priceWriterAdapter->write($articleId, $articleOrderNumber, $articlePriceData);

        /** @var Connection $dbalConnection */
        $dbalConnection = Shopware()->Container()->get('dbal_connection');
        $updatedArticle = $dbalConnection->executeQuery("SELECT * FROM s_articles_prices WHERE articleID='{$articleId}'")->fetchAll();

        static::assertEquals($expectedArticlePrice, $updatedArticle[0]['price']);
    }

    public function testWriteShouldUpdateArticlePseudoPrice()
    {
        $priceWriterAdapter = $this->createPriceWriterAdapter();

        $articlePriceData = [
            [
                'price' => '9,95',
                'priceGroup' => 'EK',
                'pseudoPrice' => '15,95',
            ],
        ];
        $articleOrderNumber = 3;
        $articleId = 3;
        $expectedArticlePseudoPrice = 13.403361344538;

        $priceWriterAdapter->write($articleId, $articleOrderNumber, $articlePriceData);

        /** @var Connection $dbalConnection */
        $dbalConnection = Shopware()->Container()->get('dbal_connection');
        $updatedArticle = $dbalConnection->executeQuery("SELECT * FROM s_articles_prices WHERE articleID='{$articleId}'")->fetchAll();

        static::assertEquals($expectedArticlePseudoPrice, $updatedArticle[0]['pseudoprice']);
    }

    /**
     * @return PriceWriter
     */
    private function createPriceWriterAdapter()
    {
        return new PriceWriter();
    }
}

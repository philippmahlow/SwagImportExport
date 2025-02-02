<?php
/**
 * (c) shopware AG <info@shopware.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Shopware\Components\SwagImportExport\Functional\Components\SwagImportExport\Factories;

use PHPUnit\Framework\TestCase;
use Shopware\Components\SwagImportExport\DbAdapters\AddressDbAdapter;
use Shopware\Components\SwagImportExport\DbAdapters\ArticlesDbAdapter;
use Shopware\Components\SwagImportExport\DbAdapters\ArticlesImagesDbAdapter;
use Shopware\Components\SwagImportExport\DbAdapters\ArticlesInStockDbAdapter;
use Shopware\Components\SwagImportExport\DbAdapters\ArticlesPricesDbAdapter;
use Shopware\Components\SwagImportExport\DbAdapters\CategoriesDbAdapter;
use Shopware\Components\SwagImportExport\DbAdapters\CustomerDbAdapter;
use Shopware\Components\SwagImportExport\DbAdapters\DataDbAdapter;
use Shopware\Components\SwagImportExport\DbAdapters\MainOrdersDbAdapter;
use Shopware\Components\SwagImportExport\DbAdapters\NewsletterDbAdapter;
use Shopware\Components\SwagImportExport\DbAdapters\OrdersDbAdapter;
use Shopware\Components\SwagImportExport\DbAdapters\TranslationsDbAdapter;
use Shopware\Components\SwagImportExport\Factories\DataFactory;

class DataFactoryTest extends TestCase
{
    public function testCreateDbAdapterShouldCreateAddressDbAdapter()
    {
        $dataFactory = $this->createDataFactory();

        $addressDbAdapter = $dataFactory->createDbAdapter('addresses');

        static::assertInstanceOf(AddressDbAdapter::class, $addressDbAdapter);
        static::assertInstanceOf(DataDbAdapter::class, $addressDbAdapter);
    }

    public function testCreateDbAdapterShouldCreateCategoriesDbAdapter()
    {
        $dataFactory = $this->createDataFactory();

        $categoriesDbAdapter = $dataFactory->createDbAdapter('categories');

        static::assertInstanceOf(CategoriesDbAdapter::class, $categoriesDbAdapter);
        static::assertInstanceOf(DataDbAdapter::class, $categoriesDbAdapter);
    }

    public function testCreateDbAdapterShouldCreateArticlesDbAdapter()
    {
        $dataFactory = $this->createDataFactory();

        $articlesDbAdapter = $dataFactory->createDbAdapter('articles');

        static::assertInstanceOf(ArticlesDbAdapter::class, $articlesDbAdapter);
        static::assertInstanceOf(DataDbAdapter::class, $articlesDbAdapter);
    }

    public function testCreateDbAdapterShouldCreateArticlesInstockDbAdapter()
    {
        $dataFactory = $this->createDataFactory();

        $articlesInstockDbAdapter = $dataFactory->createDbAdapter('articlesInStock');

        static::assertInstanceOf(ArticlesInStockDbAdapter::class, $articlesInstockDbAdapter);
        static::assertInstanceOf(DataDbAdapter::class, $articlesInstockDbAdapter);
    }

    public function testCreateDbAdapterShouldCreateArticlesPricesDbAdapter()
    {
        $dataFactory = $this->createDataFactory();

        $articlesPricesDbAdapter = $dataFactory->createDbAdapter('articlesPrices');

        static::assertInstanceOf(ArticlesPricesDbAdapter::class, $articlesPricesDbAdapter);
        static::assertInstanceOf(DataDbAdapter::class, $articlesPricesDbAdapter);
    }

    public function testCreateDbAdapterShouldCreateOrdersDbAdapter()
    {
        $dataFactory = $this->createDataFactory();

        $ordersDbAdapter = $dataFactory->createDbAdapter('orders');

        static::assertInstanceOf(OrdersDbAdapter::class, $ordersDbAdapter);
        static::assertInstanceOf(DataDbAdapter::class, $ordersDbAdapter);
    }

    public function testCreateDbAdapterShouldCreateMainOrderDbAdapter()
    {
        $dataFactory = $this->createDataFactory();

        $mainOrdersDbAdapter = $dataFactory->createDbAdapter('mainOrders');

        static::assertInstanceOf(MainOrdersDbAdapter::class, $mainOrdersDbAdapter);
        static::assertInstanceOf(DataDbAdapter::class, $mainOrdersDbAdapter);
    }

    public function testCreateDbAdapterShouldCreateCustomerDbAdapter()
    {
        $dataFactory = $this->createDataFactory();

        $customerDbAdapter = $dataFactory->createDbAdapter('customers');

        static::assertInstanceOf(CustomerDbAdapter::class, $customerDbAdapter);
        static::assertInstanceOf(DataDbAdapter::class, $customerDbAdapter);
    }

    public function testCreateDbAdapterShouldCreateNewsletterDbAdapter()
    {
        $dataFactory = $this->createDataFactory();

        $newsletterDbAdapter = $dataFactory->createDbAdapter('newsletter');

        static::assertInstanceOf(NewsletterDbAdapter::class, $newsletterDbAdapter);
        static::assertInstanceOf(DataDbAdapter::class, $newsletterDbAdapter);
    }

    public function testCreateDbAdapterShouldCreateTranslationsDbAdapter()
    {
        $dataFactory = $this->createDataFactory();

        $translationsDbAdapter = $dataFactory->createDbAdapter('translations');

        static::assertInstanceOf(TranslationsDbAdapter::class, $translationsDbAdapter);
        static::assertInstanceOf(DataDbAdapter::class, $translationsDbAdapter);
    }

    public function testCreateDbAdapterShouldCreateArticlesImagesDbAdapter()
    {
        $dataFactory = $this->createDataFactory();

        $articlesImagesDbAdapter = $dataFactory->createDbAdapter('articlesImages');

        static::assertInstanceOf(ArticlesImagesDbAdapter::class, $articlesImagesDbAdapter);
        static::assertInstanceOf(DataDbAdapter::class, $articlesImagesDbAdapter);
    }

    /**
     * @return TestableDataFactory
     */
    private function createDataFactory()
    {
        return new TestableDataFactory();
    }
}

class TestableDataFactory extends DataFactory
{
    public function __construct()
    {
    }
}

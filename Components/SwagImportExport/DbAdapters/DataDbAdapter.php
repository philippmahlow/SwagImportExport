<?php
/**
 * (c) shopware AG <info@shopware.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Shopware\Components\SwagImportExport\DbAdapters;

interface DataDbAdapter
{
    public const ARTICLE_ADAPTER = 'articles';
    public const ARTICLE_IMAGE_ADAPTER = 'articlesImages';
    public const ARTICLE_INSTOCK_ADAPTER = 'articlesInStock';
    public const ARTICLE_TRANSLATION_ADAPTER = 'articlesTranslations';
    public const ARTICLE_PRICE_ADAPTER = 'articlesPrices';
    public const CATEGORIES_ADAPTER = 'categories';
    public const CATEGORIES_TRANSLATION_ADAPTER = 'categoriesTranslations';
    public const ORDER_ADAPTER = 'orders';
    public const MAIN_ORDER_ADAPTER = 'mainOrders';
    public const CUSTOMER_ADAPTER = 'customers';
    public const CUSTOMER_COMPLETE_ADAPTER = 'customersComplete';
    public const NEWSLETTER_RECIPIENTS_ADAPTER = 'newsletter';
    public const TRANSLATION_ADAPTER = 'translations';
    public const ADDRESS_ADAPTER = 'addresses';

    /**
     * Reads all records with the given ids and selects the passed columns.
     *
     * @param array $ids
     * @param array $columns
     *
     * @return array
     */
    public function read($ids, $columns);

    /**
     * Returns all ids for the given export with the given parameters.
     *
     * @param int $start
     * @param int $limit
     *
     * @return array
     */
    public function readRecordIds($start, $limit, $filter);

    /**
     * Returns the default column.
     *
     * @see DataDbAdapter::getColumns()
     *
     * @return array
     */
    public function getDefaultColumns();

    /**
     * Returns all iteration nodes, i.e. for articles it configuratiors, similar, ...
     *
     * @return array
     */
    public function getSections();

    /**
     * Returns all column names.
     *
     * @example:
     * [
     *  'address.id as id',
     *  'address.firstname as firstname'
     * ]
     *
     * @param string $section
     *
     * @return array
     */
    public function getColumns($section);

    /**
     * Creates, updates and validates the imported records.
     *
     * @param array $records
     */
    public function write($records);

    /**
     * Returns unprocessed data. This will be used every time if an import wants to create data which relies on created data.
     * For instance article images, similar or accessory articles.
     *
     * @return array|null
     */
    public function getUnprocessedData();

    /**
     * Returns all log messages as an array.
     *
     * @return array<string>
     */
    public function getLogMessages();

    /**
     * Returns true if log messages are available.
     *
     * @return string
     */
    public function getLogState();
}

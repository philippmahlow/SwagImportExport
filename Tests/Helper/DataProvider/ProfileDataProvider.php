<?php
/**
 * (c) shopware AG <info@shopware.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SwagImportExport\Tests\Helper\DataProvider;

use Doctrine\DBAL\Connection;
use Shopware\Components\SwagImportExport\Utils\TreeHelper;

class ProfileDataProvider
{
    public const ARTICLE_PROFILE_TYPE = 'articles';
    public const ARTICLE_PROFILE_NAME = 'article_profile';
    public const ARTICLE_TABLE = 's_articles';

    public const VARIANT_PROFILE_TYPE = 'articles';
    public const VARIANT_PROFILE_NAME = 'variant_profile';
    public const VARIANT_TABLE = 's_articles_details';

    public const CUSTOMER_PROFILE_TYPE = 'customers';
    public const CUSTOMER_PROFILE_NAME = 'customer_profile';
    public const CUSTOMER_TABLE = 's_user';

    public const CATEGORY_PROFILE_TYPE = 'categories';
    public const CATEGORY_PROFILE_NAME = 'category_profile';
    public const CATEGORY_TABLE = 's_categories';

    public const ARTICLES_INSTOCK_PROFILE_TYPE = 'articlesInStock';
    public const ARTICLES_INSTOCK_PROFILE_NAME = 'article_instock_profile';

    public const ARTICLES_PRICES_PROFILE_TYPE = 'articlesPrices';
    public const ARTICLES_PRICES_PROFILE_NAME = 'articles_price_profile';

    public const ARTICLES_IMAGES_PROFILE_TYPE = 'articlesImages';
    public const ARTICLES_IMAGE_PROFILE_NAME = 'articles_image_profile';

    public const ARTICLES_TRANSLATIONS_PROFILE_TYPE = 'articlesTranslations';
    public const ARTICLES_TRANSLATIONS_PROFILE_NAME = 'articles_translations_profile';

    public const ORDERS_PROFILE_TYPE = 'orders';
    public const ORDERS_PROFILE_NAME = 'order_profile';
    public const ORDER_TABLE = 's_order';

    public const MAIN_ORDERS_PROFILE_TYPE = 'mainOrders';
    public const MAIN_ORDERS_PROFILE_NAME = 'main_order_profile';
    public const IMPORT_MAIN_ORDER_PROFILE_NAME = 'import_main_order_profile';

    public const TRANSLATIONS_PROFILE_TYPE = 'translations';
    public const TRANSLATIONS_PROFILE_NAME = 'translation_profile';

    public const NEWSLETTER_PROFILE_TYPE = 'newsletter';
    public const NEWSLETTER_PROFILE_NAME = 'newsletter_profile';
    public const NEWSLETTER_TABLE = 's_campaigns_mailaddresses';

    /**
     * @var array - Indexed by profile type
     */
    private $profileIds = [];

    /**
     * @var Connection
     */
    private $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function createProfiles()
    {
        $this->createProfile(self::ARTICLE_PROFILE_TYPE, self::ARTICLE_PROFILE_NAME);
        $this->createProfile(self::VARIANT_PROFILE_TYPE, self::VARIANT_PROFILE_NAME);
        $this->createProfile(self::CUSTOMER_PROFILE_TYPE, self::CUSTOMER_PROFILE_NAME);
        $this->createProfile(self::CATEGORY_PROFILE_TYPE, self::CATEGORY_PROFILE_NAME);
        $this->createProfile(self::ARTICLES_INSTOCK_PROFILE_TYPE, self::ARTICLES_INSTOCK_PROFILE_NAME);
        $this->createProfile(self::ARTICLES_PRICES_PROFILE_TYPE, self::ARTICLES_PRICES_PROFILE_NAME);
        $this->createProfile(self::ARTICLES_IMAGES_PROFILE_TYPE, self::ARTICLES_IMAGE_PROFILE_NAME);
        $this->createProfile(self::ARTICLES_TRANSLATIONS_PROFILE_TYPE, self::ARTICLES_TRANSLATIONS_PROFILE_NAME);
        $this->createProfile(self::ORDERS_PROFILE_TYPE, self::ORDERS_PROFILE_NAME);
        $this->createProfile(self::MAIN_ORDERS_PROFILE_TYPE, self::MAIN_ORDERS_PROFILE_NAME);
        $this->createProfile(self::TRANSLATIONS_PROFILE_TYPE, self::TRANSLATIONS_PROFILE_NAME);
        $this->createProfile(self::NEWSLETTER_PROFILE_TYPE, self::NEWSLETTER_PROFILE_NAME);
    }

    /**
     * @param string $type
     *
     * @return int
     */
    public function getIdByProfileType($type)
    {
        if (!\array_key_exists($type, $this->profileIds)) {
            throw new \RuntimeException("Profile type {$type} not found.");
        }

        return $this->profileIds[$type];
    }

    public function getProfileId(string $profile): int
    {
        $queryBuilder = $this->connection->createQueryBuilder();

        return (int) $queryBuilder->select('id')
            ->from('s_import_export_profile')
            ->where('type = :profileType')
            ->orWhere('name = :profileName')
            ->setParameter('profileType', $profile)
            ->setParameter('profileName', $profile)
            ->execute()
            ->fetch(\PDO::FETCH_COLUMN);
    }

    private function createProfile(string $profileType, string $profileName): void
    {
        if ($this->isProfileInstalled($profileType)) {
            return;
        }

        $defaultTree = TreeHelper::getDefaultTreeByProfileType($profileType);

        $queryBuilder = $this->connection->createQueryBuilder();
        $queryBuilder->insert('s_import_export_profile')
            ->setValue('type', ':type')
            ->setValue('base_profile', 'NULL')
            ->setValue('name', ':name')
            ->setValue('description', ':description')
            ->setValue('tree', ':tree')
            ->setValue('hidden', 0)
            ->setValue('is_default', 1)
            ->setParameter('type', $profileType)
            ->setParameter('name', $profileName)
            ->setParameter('description', $profileName . '_description_unit_test')
            ->setParameter('tree', $defaultTree);

        $queryBuilder->execute();

        $this->profileIds[$profileType] = $queryBuilder->getConnection()->lastInsertId();
    }

    private function isProfileInstalled(string $profileType): bool
    {
        return (bool) $this->getProfileId($profileType);
    }
}

<?php
/**
 * (c) shopware AG <info@shopware.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SwagImportExport\Tests\Unit\Setup\DefaultProfiles;

use PHPUnit\Framework\TestCase;
use Shopware\Setup\SwagImportExport\DefaultProfiles\OrderMainDataProfile;
use Shopware\Setup\SwagImportExport\DefaultProfiles\ProfileMetaData;

class OrderMainDataProfileTest extends TestCase
{
    use DefaultProfileTestCaseTrait;

    public function testItCanBeCreated()
    {
        $orderMainDataProfile = new OrderMainDataProfile();

        static::assertInstanceOf(OrderMainDataProfile::class, $orderMainDataProfile);
        static::assertInstanceOf(ProfileMetaData::class, $orderMainDataProfile);
        static::assertInstanceOf(\JsonSerializable::class, $orderMainDataProfile);
    }

    public function testItShouldReturnValidProfile()
    {
        $orderMainDataProfile = new OrderMainDataProfile();

        $this->walkRecursive($orderMainDataProfile->jsonSerialize(), function ($node) {
            $this->assertArrayHasKey('id', $node, 'Current array: ' . \print_r($node, true));
            $this->assertArrayHasKey('type', $node, 'Current array: ' . \print_r($node, true));
            $this->assertArrayHasKey('name', $node, 'Current array: ' . \print_r($node, true));
        });
    }
}

<?php
namespace Virgil\Sdk\Tests\Unit\Client\VirgilServices\Mapper;


use Virgil\Sdk\Client\Requests\Constants\CardScopes;

use Virgil\Sdk\Client\VirgilServices\Mapper\CardContentModelMapper;

use Virgil\Sdk\Client\VirgilServices\Model\CardContentModel;
use Virgil\Sdk\Client\VirgilServices\Model\DeviceInfoModel;

class CardContentModelMapperTest extends AbstractMapperTest
{
    /**
     * @dataProvider toJsonFromCardContentModelDataProvider
     *
     * @param string $expectedCardContentModelJson
     * @param array  $cardContentModelData
     *
     * @test
     */
    public function toJson__fromCardContentModel__returnsValidCardContentModelJsonString(
        $expectedCardContentModelJson,
        array $cardContentModelData
    ) {
        $cardContentModel = $this->createCardContentModel($cardContentModelData);


        $cardContentModelJson = $this->mapper->toJson($cardContentModel);


        $this->assertEquals($expectedCardContentModelJson, $cardContentModelJson);
    }


    /**
     * @dataProvider toModelFromCardContentModeDataProvider
     *
     * @param string $cardContentModelJson
     * @param array  $expectedCardContentModelData
     *
     * @test
     */
    public function toModel__fromCardContentModelJsonString__returnsValidCardContentModel(
        $cardContentModelJson,
        array $expectedCardContentModelData
    ) {
        $expectedCardContentModel = $this->createCardContentModel($expectedCardContentModelData);


        $cardContentModel = $this->mapper->toModel($cardContentModelJson);


        $this->assertEquals($expectedCardContentModel, $cardContentModel);
    }


    public function toJsonFromCardContentModelDataProvider()
    {
        return [
            [
                '{"identity":"alice","identity_type":"member","public_key":"public-key","scope":"application"}',
                ['alice', 'member', 'public-key', CardScopes::TYPE_APPLICATION, []],
            ],
        ];
    }


    public function toModelFromCardContentModeDataProvider()
    {
        return [
            [
                '{"identity":"alice","identity_type":"member","public_key":"public-key","scope":"application","data":null}',
                ['alice', 'member', 'public-key', CardScopes::TYPE_APPLICATION, []],
            ],
            [
                '{"identity":"alice2","identity_type":"member","public_key":"public-key-2","data":{"customData":"qwerty"},"scope":"global","info":{"device":"iPhone6s","device_name":"Space grey one"}}',
                [
                    'alice2',
                    'member',
                    'public-key-2',
                    CardScopes::TYPE_GLOBAL,
                    ['customData' => 'qwerty'],
                    new DeviceInfoModel('iPhone6s', 'Space grey one'),
                ],
            ],
        ];
    }


    protected function getMapper()
    {
        return $this->createCreateCardContentModelMapper();
    }


    private function createCreateCardContentModelMapper()
    {
        return new CardContentModelMapper();
    }


    private function createCardContentModel($cardContentModelData)
    {
        return new CardContentModel(...$cardContentModelData);
    }
}

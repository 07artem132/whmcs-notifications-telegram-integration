<?php
namespace Virgil\Sdk\Tests\Unit\Client\Validator;


use DateTime;

use Virgil\Sdk\Tests\BaseTestCase;

use Virgil\Sdk\Buffer;

use Virgil\Sdk\Client\Card;

use Virgil\Sdk\Cryptography\VirgilCrypto;

use Virgil\Sdk\Client\Validator\CardValidator;

use Virgil\Sdk\Client\Requests\Constants\CardScopes;

class CardValidatorTest extends BaseTestCase
{
    /**
     * @test
     */
    public function validate__wellFormedCard__doesNotThrowException()
    {
        $validator = $this->createCardValidator();


        $validator->validate(
            new Card(
                'eb95e1b31ff3090598a05bf108c06088af5f70cfd6338924932396e9dfce840a',
                Buffer::fromBase64(
                    'eyJpZGVudGl0eSI6ImFsaWNlIiwiaWRlbnRpdHlfdHlwZSI6Im1lbWJlciIsInB1YmxpY19rZXkiOiJNQ293QlFZREsyVndBeUVBWnpCdEVRRVdNUTlWZUpycVNvTzkzOVZSNXFpbWFUczRyZXFlOXV0MVZQaz0iLCJzY29wZSI6ImFwcGxpY2F0aW9uIiwiZGF0YSI6e30sImluZm8iOm51bGx9'
                ),
                'alice2',
                'member',
                Buffer::fromBase64('MCowBQYDK2VwAyEAZzBtEQEWMQ9VeJrqSoO939VR5qimaTs4reqe9ut1VPk='),
                CardScopes::TYPE_GLOBAL,
                [],
                null,
                null,
                '4.0',
                [
                    'eb95e1b31ff3090598a05bf108c06088af5f70cfd6338924932396e9dfce840a' => Buffer::fromBase64(
                        'MFEwDQYJYIZIAWUDBAICBQAEQFpw+jB5eDT1Dj3I2WqCewGqhAdG9f8pncAYeYcWHGWIONZlog1gjBb/y5/km8VbIPjrn4wlF0Ld8L5tRqRZOQM='
                    ),
                    '3e29d43373348cfb373b7eae189214dc01d7237765e572db685839b64adca853' => Buffer::fromBase64(
                        'MFEwDQYJYIZIAWUDBAICBQAEQMpaO3OmXlsYhzR7pvF0Xuu7Dv84r3SRrmqjMvod9ik+oQ0M0uc+dwHNeNtQpy84qI14cXXaMAJDcfgtKyHPdA0='
                    ),
                ],
                new DateTime()
            )
        );


        $this->assertTrue(true);
    }


    /**
     * @test
     */
    public function validate__cardWithoutApplicationSign__doesNotThrowExceptionIfBuiltInVerifiersIsDisabled()
    {
        $validator = $this->createCardValidator(false);


        $validator->validate(
            new Card(
                'eb95e1b31ff3090598a05bf108c06088af5f70cfd6338924932396e9dfce840a',
                Buffer::fromBase64(
                    'eyJpZGVudGl0eSI6ImFsaWNlIiwiaWRlbnRpdHlfdHlwZSI6Im1lbWJlciIsInB1YmxpY19rZXkiOiJNQ293QlFZREsyVndBeUVBWnpCdEVRRVdNUTlWZUpycVNvTzkzOVZSNXFpbWFUczRyZXFlOXV0MVZQaz0iLCJzY29wZSI6ImFwcGxpY2F0aW9uIiwiZGF0YSI6e30sImluZm8iOm51bGx9'
                ),
                'alice2',
                'member',
                Buffer::fromBase64('MCowBQYDK2VwAyEAZzBtEQEWMQ9VeJrqSoO939VR5qimaTs4reqe9ut1VPk='),
                CardScopes::TYPE_GLOBAL,
                [],
                null,
                null,
                '4.0',
                [
                    'eb95e1b31ff3090598a05bf108c06088af5f70cfd6338924932396e9dfce840a' => Buffer::fromBase64(
                        'MFEwDQYJYIZIAWUDBAICBQAEQFpw+jB5eDT1Dj3I2WqCewGqhAdG9f8pncAYeYcWHGWIONZlog1gjBb/y5/km8VbIPjrn4wlF0Ld8L5tRqRZOQM='
                    ),
                ],
                new DateTime()
            )
        );


        $this->assertTrue(true);
    }


    /**
     * @expectedException \Virgil\Sdk\Client\Validator\CardValidationException
     *
     * @test
     */
    public function validate__cardWithBadSelfSignOnly__throwsException()
    {
        $validator = $this->createCardValidator();


        $validator->validate(
            new Card(
                'eb95e1b31ff3090598a05bf108c06088af5f70cfd6338924932396e9dfce840a',
                Buffer::fromBase64(
                    'eyJpZGVudGl0eSI6ImFsaWNlMiIsImlkZW50aXR5X3R5cGUiOiJtZW1iZXIiLCJwdWJsaWNfa2V5IjoiTUNvd0JRWURLMlZ3QXlFQXB0ZUx6Szh1VGtQRjZmeWJXWHV2VkxUZlJnOUsxY3hnWjZBU1g4VTJiVnM9IiwiZGF0YSI6eyJjdXN0b21EYXRhIjoicXdlcnR5In0sInNjb3BlIjoiZ2xvYmFsIiwiaW5mbyI6eyJkZXZpY2UiOiJpUGhvbmU2cyIsImRldmljZV9uYW1lIjoiU3BhY2UgZ3JleSBvbmUifX0='
                ),
                'alice2',
                'member',
                Buffer::fromBase64('MCowBQYDK2VwAyEApteLzK8uTkPF6fybWXuvVLTfRg9K1cxgZ6ASX8U2bVs='),
                CardScopes::TYPE_GLOBAL,
                ['customData' => 'qwerty'],
                'iPhone6s',
                'Space grey one',
                'v4',
                [
                    'eb95e1b31ff3090598a05bf108c06088af5f70cfd6338924932396e9dfce840a' => Buffer::fromBase64(
                        'AKEwDQYJYIZIAWUDBAICBQAEQFpw+jB5eDT1Dj3I2WqCewGqhAdG9f8pncAYeYcWHGWIONZlog1gjBb/y5/km8VbIPjrn4wlF0Ld8L5tRqRZOQM='
                    ),
                    '3e29d43373348cfb373b7eae189214dc01d7237765e572db685839b64adca853' => Buffer::fromBase64(
                        'MFEwDQYJYIZIAWUDBAICBQAEQMpaO3OmXlsYhzR7pvF0Xuu7Dv84r3SRrmqjMvod9ik+oQ0M0uc+dwHNeNtQpy84qI14cXXaMAJDcfgtKyHPdA0='
                    ),
                ],
                new DateTime()
            )
        );


        //expected thrown exception
    }


    /**
     * @expectedException \Virgil\Sdk\Client\Validator\CardValidationException
     *
     * @test
     */
    public function validate__cardWithBadCardIdOnly__throwsException()
    {
        $validator = $this->createCardValidator();


        $validator->validate(
            new Card(
                'ee2be60bd1f98564641da899ee37e517540d039ae3668e6261a6642427d4c82a',
                Buffer::fromBase64(
                    'eyJpZGVudGl0eSI6ImFsaWNlMiIsImlkZW50aXR5X3R5cGUiOiJtZW1iZXIiLCJwdWJsaWNfa2V5IjoiTUNvd0JRWURLMlZ3QXlFQXB0ZUx6Szh1VGtQRjZmeWJXWHV2VkxUZlJnOUsxY3hnWjZBU1g4VTJiVnM9IiwiZGF0YSI6eyJjdXN0b21EYXRhIjoicXdlcnR5In0sInNjb3BlIjoiZ2xvYmFsIiwiaW5mbyI6eyJkZXZpY2UiOiJpUGhvbmU2cyIsImRldmljZV9uYW1lIjoiU3BhY2UgZ3JleSBvbmUifX0='
                ),
                'alice2',
                'member',
                Buffer::fromBase64('MCowBQYDK2VwAyEApteLzK8uTkPF6fybWXuvVLTfRg9K1cxgZ6ASX8U2bVs='),
                CardScopes::TYPE_GLOBAL,
                ['customData' => 'qwerty'],
                'iPhone6s',
                'Space grey one',
                'v4',
                [
                    'qwerty123'                                                        => Buffer::fromBase64(
                        'MFEwDQYJYIZIAWUDBAICBQAEQFpw+jB5eDT1Dj3I2WqCewGqhAdG9f8pncAYeYcWHGWIONZlog1gjBb/y5/km8VbIPjrn4wlF0Ld8L5tRqRZOQM='
                    ),
                    '3e29d43373348cfb373b7eae189214dc01d7237765e572db685839b64adca853' => Buffer::fromBase64(
                        'MFEwDQYJYIZIAWUDBAICBQAEQMpaO3OmXlsYhzR7pvF0Xuu7Dv84r3SRrmqjMvod9ik+oQ0M0uc+dwHNeNtQpy84qI14cXXaMAJDcfgtKyHPdA0='
                    ),
                ],
                new DateTime()
            )
        );


        //expected thrown exception
    }


    /**
     * @test
     */
    public function validate__cardLegacy3Version__doesNotThrowExceptionInAllCases()
    {
        $validator = $this->createCardValidator();


        $validator->validate(
            new Card(
                'ee2be60bd1f98564641da899ee37e517540d039ae3668e6261a6642427d4c82a',
                Buffer::fromBase64(
                    'eyJpZGVudGl0eSI6ImFsaWNlMiIsImlkZW50aXR5X3R5cGUiOiJtZW1iZXIiLCJwdWJsaWNfa2V5IjoiTUNvd0JRWURLMlZ3QXlFQXB0ZUx6Szh1VGtQRjZmeWJXWHV2VkxUZlJnOUsxY3hnWjZBU1g4VTJiVnM9IiwiZGF0YSI6eyJjdXN0b21EYXRhIjoicXdlcnR5In0sInNjb3BlIjoiZ2xvYmFsIiwiaW5mbyI6eyJkZXZpY2UiOiJpUGhvbmU2cyIsImRldmljZV9uYW1lIjoiU3BhY2UgZ3JleSBvbmUifX0='
                ),
                'alice2',
                'member',
                Buffer::fromBase64('MCowBQYDK2VwAyEApteLzK8uTkPF6fybWXuvVLTfRg9K1cxgZ6ASX8U2bVs='),
                CardScopes::TYPE_GLOBAL,
                ['customData' => 'qwerty'],
                'iPhone6s',
                'Space grey one',
                Card::LEGACY_CARD_VERSION,
                [],
                new DateTime()
            )
        );


        //does not expected thrown exception
    }


    protected function createCardValidator($useBuiltInVerifiers = true)
    {
        $crypto = new VirgilCrypto();

        return new CardValidator($crypto, $useBuiltInVerifiers);
    }
}

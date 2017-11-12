<?php
namespace Virgil\Sdk\Tests\Unit\Client\Requests;


use Virgil\Sdk\Tests\BaseTestCase;

use Virgil\Sdk\Buffer;

use Virgil\Sdk\Client\VirgilServices\Model\DeviceInfoModel;

use Virgil\Sdk\Client\Requests\Constants\CardScopes;

use Virgil\Sdk\Client\Requests\CreateCardRequest;

class CreateCardRequestTest extends BaseTestCase
{
    /**
     * @test
     */
    public function export__fromCardRequest__importsOriginalCardRequest()
    {
        $signs = [
            "af6799a2f26376731abb9abf32b5f2ac0933013f42628498adb6b12702df1a87" => Buffer::fromBase64(
                "MIGaMA0GCWCGSAFlAwQCAgUABIGIMIGFAkAUkHTx9vEXcUAq9O5bRsfJ0K5s8Bwm55gEXfzbdtAfr6ihJOXA9MAdXOEocqKtH6DuU7zJAdWgqfTrweih7jAkEAgN7CeUXwZwS0lRslWulaIGvpK65czWphRwyuwN++hI6dlHOdPABmhMSqimwoRsLN8xsivhPqQdLow5rDFic7A=="
            ),
            "767b6b12702df1a873f42628498f32b5f31abb9ab12ac09af6799a2f263330ad" => Buffer::fromBase64(
                "MIGaMA0GCWCGSAFlAwQCAgUABIGIMIGFAkBg9WJPxgq1ObqxPpXdomNIDxlOvyGdI9wrgZYXu+YAibJd+8Vf0uFce9QrB7yiG2U2zTNVqwsg4f7bd1SKVleAkEAplvCmFJ6v3sYQVBXerr8Yb25UllbTDuCw5alWSfBw2j3ueFiXTiyY885y0detX08YFEWYgbAoKtJgModQTEcQ=="
            ),
            "ab799a2f26333c09af6628496b12702df1a80ad767b73f42b9ab12a8f32b5f31" => Buffer::fromBase64(
                "MIGaMA0GCWCGSAFlAwQCAgUABf7bd1SKVleAkEAplvCmFJ6v3sYQVBXerr8Yb25UllbTDuCw5alWSfBw2j3ueFiXTiyY88bAoKtJgModQTEc9WJPxgq1Obqx5y0dIGIMIGFAkBgwrgZYXu+YAibJd+8Vf0uFce9QrB7yiG2U2zTNVqwsg4etX08YFEWYgPpXdomNIDxlOvyGdI9Q=="
            ),
        ];
        $request = new CreateCardRequest(
            'alice',
            'member',
            new Buffer('public-key'),
            CardScopes::TYPE_APPLICATION,
            ['customData' => 'qwerty'],
            new DeviceInfoModel('iPhone6s')
        );

        foreach ($signs as $signKey => $sign) {
            $request->appendSignature($signKey, $sign);
        }


        $exportedRequest = $request->export();
        $importedRequest = $request::import($exportedRequest);


        $this->assertEquals($request, $importedRequest);
    }


    /**
     * @test
     */
    public function import__exportedCreateCardRequest__keepsExportedContentSnapshot()
    {
        $exportedRequest = 'eyJjb250ZW50X3NuYXBzaG90IjoiZXlKcFpHVnVkR2wwZVNJNkltTnZiUzUyWVdScGJTMTBaWE4wTG1ScGJXRnpJaXdpYVdSbGJuUnBkSGxmZEhsd1pTSTZJbUZ3Y0d4cFkyRjBhVzl1SWl3aWNIVmliR2xqWDJ0bGVTSTZJazFEYjNkQ1VWbEVTekpXZDBGNVJVRTRLMFp0V1N0R1dHeEtOSGxNWVZwTk5ETkdaMUozWjBWVVVWSjJOMkYxVFRKVlFWbEtNVXh1WkVWVlBTSXNJbk5qYjNCbElqb2laMnh2WW1Gc0lpd2laR0YwWVNJNmJuVnNiSDA9IiwibWV0YSI6eyJzaWducyI6eyIyNDIxY2VmY2M1MWRkYmUyZDQ3YzJkMzU1NGFkYzUzYmNlNTlhNWIzODZmMzdjZDIwYWMzMzE5NTkxOGJlODUxIjoiTUZFd0RRWUpZSVpJQVdVREJBSUNCUUFFUURQaENkUnhFU1JhTTJqeU52NnRBTG9UakVlUk9tcDUrMDNkbWdYcld6TVQ3VHVjLzdPa1A5NzFqbmNWWG1kcnBZSnIwcldVRTdvRDI3SnEvOVBObGc4PSJ9fX0=';
        $expectedContentSnapshot = 'eyJpZGVudGl0eSI6ImNvbS52YWRpbS10ZXN0LmRpbWFzIiwiaWRlbnRpdHlfdHlwZSI6ImFwcGxpY2F0aW9uIiwicHVibGljX2tleSI6Ik1Db3dCUVlESzJWd0F5RUE4K0ZtWStGWGxKNHlMYVpNNDNGZ1J3Z0VUUVJ2N2F1TTJVQVlKMUxuZEVVPSIsInNjb3BlIjoiZ2xvYmFsIiwiZGF0YSI6bnVsbH0=';

        /** @var CreateCardRequest $createdCardRequest */
        $createdCardRequest = CreateCardRequest::import($exportedRequest);


        $contentSnapshot = $createdCardRequest->getSnapshot();


        $this->assertEquals($expectedContentSnapshot, $contentSnapshot);
    }
}

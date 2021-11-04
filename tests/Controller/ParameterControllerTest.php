<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Console\Input\StringInput;

class ParameterControllerTest extends WebTestCase
{
    protected static $application;

    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();

        self::runCommand('app:publish-filters');
    }

    public function testFullParameterSelectionReturnedWithNoParametersSpecified(): void
    {
        $client = static::createClient();

        $client->request('GET', '/parameter');
        $responseContent = $client->getResponse()->getContent();

        self::assertResponseIsSuccessful();
        self::assertSame('{"param1":["A","B","C"],"param2":["X","Y","Z"]}', $responseContent);
    }

    /**
     * @dataProvider parameterConfiguration
     */
    public function testAParameterSelected($paramKey, $paramValue, $expectedResponse): void
    {
        $client = static::createClient();

        $client->request('GET', "/parameter?$paramKey=$paramValue");
        $responseContent = $client->getResponse()->getContent();

        self::assertResponseIsSuccessful();
        self::assertSame($expectedResponse, $responseContent);
    }

    public function testNothingReturnedWithBothParametersSpecified(): void
    {
        $client = static::createClient();

        $client->request('GET', '/parameter?param1=A&param2=X');
        $responseContent = $client->getResponse()->getContent();

        self::assertResponseIsSuccessful();
        self::assertSame('', $responseContent);
    }

    public function parameterConfiguration(): array
    {
        return [
            ['param1', 'A', '{"param1":["A"],"param2":["X","Z"]}'],
            ['param1', 'B', '{"param1":["B"],"param2":["X","Y","Z"]}'],
            ['param1', 'C', '{"param1":["C"],"param2":["X","Y"]}'],
            ['param2', 'X', '{"param2":["X"],"param1":["A","B","C"]}'],
            ['param2', 'Y', '{"param2":["Y"],"param1":["B","C"]}'],
            ['param2', 'Z', '{"param2":["Z"],"param1":["A","B"]}'],
        ];
    }

    private static function runCommand($command): void
    {
        $command = sprintf('%s --quiet', $command);

        self::getApplication()->run(new StringInput($command));
    }

    private static function getApplication()
    {
        if (null === self::$application) {
            $kernel = static::createKernel();
            self::$application = new Application($kernel);
            self::$application->setAutoExit(false);
        }

        return self::$application;
    }
}

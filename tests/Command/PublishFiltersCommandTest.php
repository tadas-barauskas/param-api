<?php

namespace App\Tests\Command;

use App\Service\FilterPublisher;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Tester\CommandTester;

class PublishFiltersCommandTest extends KernelTestCase
{
    public function testCommandRuns(): void
    {
        $kernel = static::bootKernel();
        $application = new Application($kernel);

        $emptyMock = $this->createMock(FilterPublisher::class);
        $kernel->getContainer()->set(FilterPublisher::class, $emptyMock);

        $command = $application->find('app:publish-filters');
        $commandTester = new CommandTester($command);
        $commandTester->execute([]);

        $output = $commandTester->getDisplay();
        self::assertStringContainsString('Filter params published', $output);
    }
}

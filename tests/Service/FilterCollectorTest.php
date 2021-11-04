<?php

namespace App\Tests\Service;

use App\Entity\Article;
use App\Entity\Attribute;
use App\Repository\ArticleRepository;
use App\Service\FilterCollector;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class FilterCollectorTest extends KernelTestCase
{
    /**
     * @var FilterCollector
     */
    private $sut;

    /**
     * @var ArticleRepository|mixed|\PHPUnit\Framework\MockObject\MockObject
     */
    private $repository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->repository = $this->createMock(ArticleRepository::class);

        $this->sut = new FilterCollector($this->repository);
    }

    public function testEmptyArrayCollectedWithNoProducts(): void
    {
        $this->repository->expects($this->once())
            ->method('findAll')
            ->willReturn([]);

        $filters = $this->sut->collect();

        self::assertEquals([], $filters);
    }

    public function testAllFiltersAreCollected(): void
    {
        $articles = [
            $this->getArticle('ProductA', 'A', 'X'),
            $this->getArticle('ProductB', 'A', 'Z'),
            $this->getArticle('ProductC', 'B', 'X'),
            $this->getArticle('ProductD', 'B', 'Y'),
            $this->getArticle('ProductE', 'B', 'Z'),
            $this->getArticle('ProductF', 'C', 'X'),
            $this->getArticle('ProductG', 'C', 'Y'),
        ];

        $this->repository->expects($this->once())
            ->method('findAll')
            ->willReturn($articles);

        $filters = $this->sut->collect();

        self::assertEquals(
            [
                'filters' => [
                    'param1' => ['A', 'B', 'C'],
                    'param2' => ['X', 'Y', 'Z'],

                ],
                'filters:param1:A' => [
                    'param1' => ['A'],
                    'param2' => ['X', 'Z'],
                ],
                'filters:param1:B' => [
                    'param1' => ['B'],
                    'param2' => ['X', 'Y', 'Z'],
                ],
                'filters:param1:C' => [
                    'param1' => ['C'],
                    'param2' => ['X', 'Y'],
                ],
                'filters:param2:X' => [
                    'param1' => ['A', 'B', 'C'],
                    'param2' => ['X'],
                ],
                'filters:param2:Y' => [
                    'param1' => ['B', 'C'],
                    'param2' => ['Y'],
                ],
                'filters:param2:Z' => [
                    'param1' => ['A', 'B'],
                    'param2' => ['Z'],
                ],
            ], $filters);
    }

    private function getArticle(string $name, string $param1, string $param2): Article
    {
        $attributes = [
            (new Attribute())->setKey('param1')->setValue($param1),
            (new Attribute())->setKey('param2')->setValue($param2),
        ];

        return (new Article())
            ->setName($name)
            ->addAttributes($attributes);
    }
}

<?php

namespace App\Service;

use App\Entity\Article;
use App\Repository\ArticleRepository;

class FilterCollector
{
    private const FILTER_KEY_BASE = 'filters';

    /**
     * @var ArticleRepository
     */
    private $repository;

    public function __construct(ArticleRepository $repository)
    {
        $this->repository = $repository;
    }

    public function collect(): array
    {
        if (!$articles = $this->repository->findAll()) {
            return [];
        }

        $collection = $this->collectByAttributeKeyValue($articles);

        $options = $this->formatInitialSelections($collection);
        $options = $this->addSelectedOptions($options, $collection);

        return $options;
    }

    /**
     * @param Article[] $articles
     * @return array
     */
    private function collectByAttributeKeyValue(array $articles): array
    {
        $collection = [];
        foreach ($articles as $article) {
            foreach ($article->getAttributes() as $attribute) {
                $collection[$attribute->getKey()][$attribute->getValue()][] = $article;
            }
        }
        return $collection;
    }

    private function formatInitialSelections(array $collection): array
    {
        $formatted = [];
        foreach ($collection as $key => $values) {
            $flipped = array_keys($values);
            sort($flipped);
            $formatted[self::FILTER_KEY_BASE][$key] = $flipped;
        }

        return $formatted;
    }

    private function addSelectedOptions(array $selections, array $collection): array
    {
        foreach ($selections[self::FILTER_KEY_BASE] as $key => $options) {
            foreach ($options as $option) {
                $sprintf = sprintf('%s:%s:%s', self::FILTER_KEY_BASE, $key, $option);
                $selections[$sprintf] = $this->getAvailableSelections($key, $option, $collection);
            }
        }

        return $selections;
    }

    private function getAvailableSelections(string $key, string $option, array $collection): array
    {
        $result = [$key => [$option]];

        $articlesWithSelectedOption = $collection[$key][$option];
        foreach ($articlesWithSelectedOption as $article) {
            foreach ($article->getAttributes() as $attribute) {
                if ($attribute->getKey() !== $key) {
                    $result[$attribute->getKey()][] = $attribute->getValue();
                }
            }
        }

        return $result;
    }
}

<?php

// src/DataPersister

namespace App\DataPersister;

use App\Entity\Category;
use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;

class CategoryDataPersister implements ContextAwareDataPersisterInterface
{
    public function supports($data, array $context = []): bool
    {
        // TODO: Implement supports() method.
        return $data instanceof Category;
    }

    public function persist($data, array $context = [])
    {
        // TODO: Implement persist() method.
    }

    public function remove($data, array $context = [])
    {
        // TODO: Implement remove() method.
    }
}

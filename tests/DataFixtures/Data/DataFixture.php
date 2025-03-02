<?php

declare(strict_types=1);

namespace App\Tests\DataFixtures\Data;

abstract class DataFixture
{
    public static abstract function tableName(): string;

    /**
     * @return array<array<string, mixed>>
     */
    public static abstract function data(): array;
}

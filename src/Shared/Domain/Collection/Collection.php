<?php

declare(strict_types=1);

namespace DogCare\Shared\Domain\Collection;

use ArrayIterator;
use Countable;
use IteratorAggregate;
use RuntimeException;
use Traversable;
use function count;
use function get_class;

/**
 * @template TKey
 * @template TValue
 * @implements IteratorAggregate<TKey, TValue>
 */
abstract class Collection implements Countable, IteratorAggregate
{
    /**
     * @var array<int, mixed>
     */
    private array $removed;

    /**
     * @var array<int, mixed>
     */
    private array $added;

    /**
     * @param array<int, mixed> $items
     */
    public function __construct(private array $items = [])
    {
        Assert::arrayOf($this->type(), $items);
    }

    abstract protected function type(): string;

    public static function empty(): static
    {
        return new static();
    }

    public function count(): int
    {
        return count($this->items());
    }

    /**
     * @return array<TValue>
     */
    public function items(): array
    {
        return $this->items;
    }

    /**
     * @return array<TValue>|null
     */
    public function last(): ?array
    {
        return empty($this->items) ? null : end($this->items);
    }

    /**
     * @return array<TValue>
     */
    public function first(): mixed
    {
        return reset($this->items);
    }

    /**
     * @param Collection<TKey, TValue> $collection
     */
    public function merge(Collection $collection, bool $removeDuplicates = true): void
    {
        foreach ($collection->getIterator() as $iterator) {
            if ($this->type() !== get_class($iterator) && $this->type() !== get_parent_class($iterator)) {
                throw new RuntimeException(
                    sprintf('Items must be <%s> instead of <%s>', get_class($iterator), $this->type()),
                );
            }

            if ($removeDuplicates && $this->contains($iterator)) {
                continue;
            }

            $this->add($iterator);
        }
    }

    /**
     * @return ArrayIterator<int, TValue>
     */
    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->items());
    }

    public function contains(mixed $itemToSearch): bool
    {
        foreach ($this->getIterator() as $item) {
            if ($item->equals($itemToSearch)) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param Collection<TKey, TValue> $collection
     */
    public function equals(Collection $collection): bool
    {
        return $this->diff($collection)->isEmpty() && $collection->diff($this)->isEmpty();
    }

    public function isEmpty(): bool
    {
        return empty($this->items);
    }

    /**
     * @param Collection<TKey, TValue> $collection
     */
    public function diff(Collection $collection): static
    {
        $diff = [];

        foreach ($this as $item) {
            $found = false;

            foreach ($collection as $otherItem) {
                if ($item->equals($otherItem)) {
                    $found = true;

                    break;
                }
            }

            if (!$found) {
                $diff[] = $item;
            }
        }

        return new static($diff);
    }

    public function add(mixed $item): void
    {
        Assert::instanceOf($this->type(), $item);

        $this->items[] = $item;

        if (!$this->checkItWasRemovedPreviouslyAndAdd($item)) {
            $this->added[] = $item;
        }
    }

    private function checkItWasRemovedPreviouslyAndAdd(mixed $item): bool
    {
        if (!isset($this->removed)) {
            return false;
        }

        foreach ($this->removed as $key => $removedItem) {
            if ($removedItem->equals($item)) {
                unset($this->removed[$key]);
                $this->removed = array_values($this->removed);

                return true;
            }
        }

        return false;
    }

    /**
     * @return array<int, mixed>
     */
    public function each(callable $callback): array
    {
        return array_map($callback, (array) $this->getIterator());
    }

    public function firstOf(callable $callback): mixed
    {
        foreach ((array) $this->getIterator() as $current) {
            if ($callback($current)) {
                return $current;
            }
        }

        return null;
    }

    /**
     * @param Collection<TKey, TValue> $items
     */
    public function mergeAndDiff(self $items): void
    {
        $this->added = [];
        $this->removed = [];

        $removed = $this->diff($items);
        $added = $items->diff($this);

        foreach ($removed as $item) {
            $this->remove($item);
        }

        foreach ($added as $item) {
            $this->add($item);
        }
    }

    public function remove(mixed $itemToRemove): void
    {
        $found = false;

        foreach ($this->getIterator() as $key => $item) {
            if ($item->equals($itemToRemove)) {
                unset($this->items[$key]);

                if (!$this->checkItWasAddedPreviouslyAndRemove($item)) {
                    $this->removed[] = $item;
                }

                $found = true;

                break;
            }
        }

        if (!$found) {
            throw new RuntimeException('Item not found');
        }

        $this->items = array_values($this->items);
    }

    private function checkItWasAddedPreviouslyAndRemove(mixed $item): bool
    {
        if (!isset($this->added)) {
            return false;
        }

        foreach ($this->added as $key => $addedItem) {
            if ($addedItem->equals($item)) {
                unset($this->added[$key]);
                $this->added = array_values($this->added);

                return true;
            }
        }

        return false;
    }

    public function hasChanges(): bool
    {
        return [] !== $this->added() || [] !== $this->removed();
    }

    /**
     * @return array<int, TValue>
     */
    public function added(): array
    {
        return $this->added ?? [];
    }

    /**
     * @return array<int, TValue>
     */
    public function removed(): array
    {
        return $this->removed ?? [];
    }
}

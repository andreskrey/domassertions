<?php
declare(strict_types=1);

namespace andreskrey\PHPUnit\Entity;

interface ComparableInterface
{
    public function getName(): string;

    public function getType(): int;

    public function getContent(): string;

    public function getAttributes(): array;

    public function isEqual(): bool;
}

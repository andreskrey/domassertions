<?php
declare(strict_types=1);

namespace andreskrey\PHPUnit\Entity;

class ComparableEntity implements ComparableInterface
{
    protected $name;
    protected $type;
    protected $content;
    protected $attributes;
    protected $isEqual = true;

    public function __construct(string $name, int $type, string $content, ?array $attributes)
    {
        $this->name = $name;
        $this->type = $type;
        $this->content = $content;
        $this->attributes = $attributes;
    }

    /**
     * {@inheritDoc}
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * {@inheritDoc}
     */
    public function getType(): int
    {
        return $this->type;
    }

    /**
     * {@inheritDoc}
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * {@inheritDoc}
     */
    public function getAttributes(): array
    {
        return $this->attributes;
    }

    /**
     * @return bool
     */
    public function isEqual(): bool
    {
        return $this->isEqual;
    }

    /**
     * @param bool $isEqual
     */
    public function setIsEqual(bool $isEqual): void
    {
        $this->isEqual = $isEqual;
    }
}

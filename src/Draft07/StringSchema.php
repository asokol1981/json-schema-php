<?php

declare(strict_types=1);

/*
 * This file is part of Json Schema PHP.
 *
 * (c) Aleksei Sokolov <asokol.beststudio@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace ASokol1981\JsonSchema\Draft07;

class StringSchema extends AbstractJsonSchema
{
    /** @var array<string> */
    protected array $enum = [];

    /** @var int|null */
    protected ?int $minLength = null;

    /** @var int|null */
    protected ?int $maxLength = null;

    /** @var string|null */
    protected ?string $pattern = null;

    /** @var string|null */
    protected ?string $format = null;

    /** @var string|null */
    protected ?string $contentMediaType = null;

    /** @var string|null */
    protected ?string $contentEncoding = null;

    /**
     * @param array<string> $enum
     */
    public function setEnum(array $enum): static
    {
        foreach ($enum as $value) {
            $this->addEnum($value);
        }
        return $this;
    }

    /**
     * @param string $value
     */
    public function addEnum(string $value): static
    {
        $this->enum[] = $value;
        return $this;
    }

    public function setMinLength(int $minLength): static
    {
        if ($minLength < 0) {
            throw new \InvalidArgumentException('Property minLength must be greater than or equal to 0');
        }
        $this->minLength = $minLength;
        return $this;
    }

    public function setMaxLength(int $maxLength): static
    {
        if ($maxLength < 0) {
            throw new \InvalidArgumentException('Property maxLength must be greater than or equal to 0');
        }
        $this->maxLength = $maxLength;
        return $this;
    }

    public function setPattern(string $pattern): static
    {
        $this->pattern = $pattern;
        return $this;
    }

    public function setFormat(string $format): static
    {
        $this->format = $format;
        return $this;
    }

    public function setFormatDate(): static
    {
        return $this->setFormat('date');
    }
    public function setFormatDateTime(): static
    {
        return $this->setFormat('date-time');
    }
    public function setFormatTime(): static
    {
        return $this->setFormat('time');
    }

    public function setFormatEmail(): static
    {
        return $this->setFormat('email');
    }
    public function setFormatIdnEmail(): static
    {
        return $this->setFormat('idn-email');
    }

    public function setFormatHostname(): static
    {
        return $this->setFormat('hostname');
    }
    public function setFormatIdnHostname(): static
    {
        return $this->setFormat('idn-hostname');
    }

    public function setFormatIpv4(): static
    {
        return $this->setFormat('ipv4');
    }
    public function setFormatIpv6(): static
    {
        return $this->setFormat('ipv6');
    }

    public function setFormatUri(): static
    {
        return $this->setFormat('uri');
    }
    public function setFormatUriReference(): static
    {
        return $this->setFormat('uri-reference');
    }

    public function setFormatIri(): static
    {
        return $this->setFormat('iri');
    }
    public function setFormatIriReference(): static
    {
        return $this->setFormat('iri-reference');
    }

    public function setFormatUuid(): static
    {
        return $this->setFormat('uuid');
    }

    public function setFormatJsonPointer(): static
    {
        return $this->setFormat('json-pointer');
    }
    public function setFormatRelativeJsonPointer(): static
    {
        return $this->setFormat('relative-json-pointer');
    }

    public function setFormatRegex(): static
    {
        return $this->setFormat('regex');
    }

    public function setContentMediaType(string $contentMediaType): static
    {
        $this->contentMediaType = $contentMediaType;
        return $this;
    }

    public function setContentEncoding(string $contentEncoding): static
    {
        $this->contentEncoding = $contentEncoding;
        return $this;
    }

    public function toArray(): array|bool
    {
        $schema = $this->applyProperties(
            [
                'type' => 'string',
            ],
            [
                // common
                '$id',
                '$schema',
                '$comment',
                'title',
                'description',
                'default',
                'examples',
                'readOnly',
                'writeOnly',
                'deprecated',
                // string
                'minLength',
                'maxLength',
                'pattern',
                'format',
                'contentMediaType',
                'contentEncoding',
            ],
        );
        if ($this->enum) {
            $schema['enum'] = $this->enum;
        }
        return $schema;
    }
}

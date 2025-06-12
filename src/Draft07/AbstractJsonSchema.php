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

use ASokol1981\JsonSchema\AbstractJsonSchema as BaseAbstractJsonSchema;

abstract class AbstractJsonSchema extends BaseAbstractJsonSchema implements JsonSchemaInterface
{
    /** draft-06 */
    protected ?string $id = null;

    /** draft-04 */
    protected ?string $schema = null;

    /** draft-07 */
    protected ?string $comment = null;

    /** draft-04 */
    protected ?string $title = null;

    /** draft-04 */
    protected ?string $description = null;

    /** draft-04 */
    protected mixed $default = null;

    /** draft-06 */
    protected ?array $examples = null;

    /** draft-07 */
    protected ?bool $readOnly = null;

    /** draft-07 */
    protected ?bool $writeOnly = null;

    /** draft-07 */
    protected ?bool $deprecated = null;

    public function setId(string $id): static
    {
        $this->id = $id;
        return $this;
    }

    public function setSchema(string $schema): static
    {
        $this->schema = $schema;
        return $this;
    }

    public function setComment(string $comment): static
    {
        $this->comment = $comment;
        return $this;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;
        return $this;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;
        return $this;
    }

    public function setDefault(mixed $default): static
    {
        $this->default = $default;
        return $this;
    }

    public function setExamples(array $examples): static
    {
        $this->examples = $examples;
        return $this;
    }

    public function setReadOnly(bool $readOnly): static
    {
        $this->readOnly = $readOnly;
        return $this;
    }

    public function setWriteOnly(bool $writeOnly): static
    {
        $this->writeOnly = $writeOnly;
        return $this;
    }

    public function setDeprecated(bool $deprecated): static
    {
        $this->deprecated = $deprecated;
        return $this;
    }

    protected function applyProperties(array $schema, array $properties): array
    {
        foreach ($properties as $property) {
            switch ($property) {
                case '$id':
                case '$schema':
                case '$comment':
                    $name = ltrim($property, '$');
                    if (!is_null($this->{$name})) {
                        $schema[$property] = $this->{$name};
                    }
                    break;

                default:
                    if (!is_null($this->{$property})) {
                        $schema[$property] = ($this->{$property} instanceof JsonSchemaInterface) ? $this->{$property}->toArray() : $this->{$property};
                    }
                    break;
            }
        }
        return $schema;
    }
}

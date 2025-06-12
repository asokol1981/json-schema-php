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

abstract class AbstractOfJsonSchema extends AbstractJsonSchema
{
    /** @var JsonSchemaInterface[] */
    protected array $schemas = [];

    /**
     * @param JsonSchemaInterface[] $schemas
     */
    public function __construct(array $schemas = [])
    {
        foreach($schemas as $schema) {
            $this->addSchema($schema);
        }
    }

    /**
     * @param JsonSchemaInterface|bool $schema
     * @return $this
     */
    public function addSchema(JsonSchemaInterface|bool $schema): static
    {
        if (is_bool($schema)) {
            $schema = $schema ? new TrueSchema() : new FalseSchema();
        }
        $this->schemas[] = $schema;
        return $this;
    }

    abstract protected function getOf(): string;

    /**
     * @return array
     */
    public function toArray(): array|bool
    {
        return $this->applyProperties(
            [
                $this->getOf() => array_map(fn(JsonSchemaInterface $schema) => $schema->toArray(), $this->schemas),
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
            ]
        );
    }
}

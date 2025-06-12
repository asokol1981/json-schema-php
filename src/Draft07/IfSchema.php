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

class IfSchema extends AbstractJsonSchema
{
    /** @var JsonSchemaInterface */
    protected JsonSchemaInterface $if;

    /** @var JsonSchemaInterface|null */
    protected ?JsonSchemaInterface $then = null;

    /** @var JsonSchemaInterface|null */
    protected ?JsonSchemaInterface $else = null;

    /**
     * @param JsonSchemaInterface|bool $if
     */
    public function __construct(JsonSchemaInterface|bool $if)
    {
        if (is_bool($if)) {
            $if = $if ? new TrueSchema() : new FalseSchema();
        }
        $this->if = $if;
    }

    /**
     * @param JsonSchemaInterface|bool $then
     */
    public function thenSchema(JsonSchemaInterface|bool $then): static
    {
        if (is_bool($then)) {
            $then = $then ? new TrueSchema() : new FalseSchema();
        }
        $this->then = $then;
        return $this;
    }

    /**
     * @param JsonSchemaInterface|bool $else
     */
    public function elseSchema(JsonSchemaInterface|bool $else): static
    {
        if (is_bool($else)) {
            $else = $else ? new TrueSchema() : new FalseSchema();
        }
        $this->else = $else;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function toArray(): array|bool
    {
        return $this->applyProperties(
            [
                'if' => $this->if->toArray(),
            ],
            [
                // if
                'then',
                'else',
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
            ],
        );
    }
}

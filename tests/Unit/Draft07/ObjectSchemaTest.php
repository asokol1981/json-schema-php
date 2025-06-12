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

namespace ASokol1981\JsonSchema\Tests\Unit\Draft07;

use ASokol1981\JsonSchema\Draft07\AbstractJsonSchema;
use ASokol1981\JsonSchema\Draft07\IntegerSchema;
use ASokol1981\JsonSchema\Draft07\ObjectSchema;
use ASokol1981\JsonSchema\Draft07\StringSchema;
use PHPUnit\Framework\Attributes\DataProvider;

class ObjectSchemaTest extends AbstractJsonSchemaTestCase
{
    protected function getSchema(): AbstractJsonSchema
    {
        return new ObjectSchema();
    }

    public static function provider(): array
    {
        return [
            'default' => [
                [],
                fn(ObjectSchema $schema) => $schema,
                [
                    'type' => 'object',
                ],
            ],
            'bool' => [
                ['name' => true],
                fn(ObjectSchema $schema) => $schema,
                [
                    'type' => 'object',
                    'properties' => [
                        'name' => true,
                    ],
                ],
            ],
            'one_property' => [
                ['name' => new StringSchema()],
                fn(ObjectSchema $schema) => $schema,
                [
                    'type' => 'object',
                    'properties' => [
                        'name' => [
                            'type' => 'string',
                        ],
                    ],
                ],
            ],
            'two_properties' => [
                [
                    'name' => new StringSchema(),
                    'age' => new IntegerSchema(),
                ],
                fn(ObjectSchema $schema) => $schema,
                [
                    'type' => 'object',
                    'properties' => [
                        'name' => [
                            'type' => 'string',
                        ],
                        'age' => [
                            'type' => 'integer',
                        ],
                    ],
                ],
            ],
            'required_as_string' => [
                [
                    'name' => new StringSchema(),
                    'age' => new IntegerSchema(),
                ],
                fn(ObjectSchema $schema) => $schema->setRequired('name'),
                [
                    'type' => 'object',
                    'properties' => [
                        'name' => [
                            'type' => 'string',
                        ],
                        'age' => [
                            'type' => 'integer',
                        ],
                    ],
                    'required' => ['name'],
                ],
            ],
            'required_as_two_strings' => [
                [],
                fn(ObjectSchema $schema) => $schema->setRequired('name', 'age'),
                [
                    'type' => 'object',
                    'required' => ['name', 'age'],
                ],
            ],
            'required_as_array' => [
                [],
                fn(ObjectSchema $schema) => $schema->setRequired(['name', 'age']),
                [
                    'type' => 'object',
                    'required' => ['name', 'age'],
                ],
            ],
            'add_required' => [
                [],
                fn(ObjectSchema $schema) => $schema->addRequired('name'),
                [
                    'type' => 'object',
                    'required' => ['name'],
                ],
            ],
            'min_properties' => [
                [],
                fn(ObjectSchema $schema) => $schema->setMinProperties(2),
                [
                    'type' => 'object',
                    'minProperties' => 2,
                ],
            ],
            'max_properties' => [
                [],
                fn(ObjectSchema $schema) => $schema->setMaxProperties(2),
                [
                    'type' => 'object',
                    'maxProperties' => 2,
                ],
            ],
            'pattern_properties' => [
                [],
                fn(ObjectSchema $schema) => $schema->setPatternProperties([
                    '.*' => new StringSchema(),
                ]),
                [
                    'type' => 'object',
                    'patternProperties' => [
                        '.*' => [
                            'type' => 'string',
                        ],
                    ],
                ],
            ],
            'pattern_properties_bool' => [
                [],
                fn(ObjectSchema $schema) => $schema->setPatternProperties([
                    '.*' => true,
                ]),
                [
                    'type' => 'object',
                    'patternProperties' => [
                        '.*' => true,
                    ],
                ],
            ],
            'property_names' => [
                [],
                fn(ObjectSchema $schema) => $schema->setPropertyNames(new StringSchema()),
                [
                    'type' => 'object',
                    'propertyNames' => [
                        'type' => 'string',
                    ],
                ],
            ],
            'property_names_bool' => [
                [],
                fn(ObjectSchema $schema) => $schema->setPropertyNames(true),
                [
                    'type' => 'object',
                    'propertyNames' => true,
                ],
            ],
            'additional_properties' => [
                [],
                fn(ObjectSchema $schema) => $schema->setAdditionalProperties(new StringSchema()),
                [
                    'type' => 'object',
                    'additionalProperties' => [
                        'type' => 'string',
                    ],
                ],
            ],
            'additional_properties_bool' => [
                [],
                fn(ObjectSchema $schema) => $schema->setAdditionalProperties(true),
                [
                    'type' => 'object',
                    'additionalProperties' => true,
                ],
            ],
            'definitions' => [
                [],
                fn(ObjectSchema $schema) => $schema->setDefinitions([
                    'name' => new StringSchema(),
                ]),
                [
                    'type' => 'object',
                    'definitions' => [
                        'name' => [
                            'type' => 'string',
                        ],
                    ],
                ],
            ],
            'definitions_bool' => [
                [],
                fn(ObjectSchema $schema) => $schema->setDefinitions([
                    'name' => true,
                ]),
                [
                    'type' => 'object',
                    'definitions' => [
                        'name' => true,
                    ],
                ],
            ],
            'dependencies' => [
                [],
                fn(ObjectSchema $schema) => $schema->setDependencies([
                    'name' => new StringSchema(),
                ]),
                [
                    'type' => 'object',
                    'dependencies' => [
                        'name' => [
                            'type' => 'string',
                        ],
                    ],
                ],
            ],
            'dependencies_bool' => [
                [],
                fn(ObjectSchema $schema) => $schema->setDependencies([
                    'name' => true,
                ]),
                [
                    'type' => 'object',
                    'dependencies' => [
                        'name' => true,
                    ],
                ],
            ],
            'all' => [
                ['name' => new StringSchema()],
                fn(ObjectSchema $schema) => $schema
                    // common
                    ->setId('id')
                    ->setSchema('schema')
                    ->setComment('comment')
                    ->setTitle('title')
                    ->setDescription('description')
                    ->setDefault('default')
                    ->setExamples(['examples'])
                    ->setReadOnly(true)
                    ->setWriteOnly(true)
                    ->setDeprecated(true)
                    // object
                    ->setMinProperties(5)
                    ->setMaxProperties(5)
                    ->setPatternProperties([
                        '.*' => new StringSchema(),
                    ])
                    ->setPropertyNames(new StringSchema())
                    ->setAdditionalProperties(new StringSchema())
                    ->setDefinitions([
                        'name' => new StringSchema(),
                    ])
                    ->setDependencies([
                        'name' => new StringSchema(),
                    ])
                    ->setRequired('name'),
                [
                    'type' => 'object',
                    // common
                    '$id' => 'id',
                    '$schema' => 'schema',
                    '$comment' => 'comment',
                    'title' => 'title',
                    'description' => 'description',
                    'default' => 'default',
                    'examples' => ['examples'],
                    'readOnly' => true,
                    'writeOnly' => true,
                    'deprecated' => true,
                    // object
                    'minProperties' => 5,
                    'maxProperties' => 5,
                    'propertyNames' => [
                        'type' => 'string',
                    ],
                    'additionalProperties' => [
                        'type' => 'string',
                    ],
                    'properties' => [
                        'name' => [
                            'type' => 'string',
                        ],
                    ],
                    'patternProperties' => [
                        '.*' => [
                            'type' => 'string',
                        ],
                    ],
                    'definitions' => [
                        'name' => [
                            'type' => 'string',
                        ],
                    ],
                    'dependencies' => [
                        'name' => [
                            'type' => 'string',
                        ],
                    ],
                    'required' => [
                        'name',
                    ],
                ],
            ],
        ];
    }

    #[DataProvider('provider')]
    public function test(array|bool $properties, \Closure $callback, array $expected)
    {
        $schema = new ObjectSchema($properties);
        $callback($schema);

        $this->assertSame($expected, $schema->toArray());
    }

    public static function exception_provider(): array
    {
        return [
            'min_properties' => [
                [],
                fn(ObjectSchema $schema) => $schema->setMinProperties(-1),
            ],
            'max_properties' => [
                [],
                fn(ObjectSchema $schema) => $schema->setMaxProperties(-1),
            ],
        ];
    }

    #[DataProvider('exception_provider')]
    public function test_exception(mixed $items, \Closure $callback)
    {
        $this->expectException(\InvalidArgumentException::class);
        $schema = new ObjectSchema($items);
        $callback($schema);
    }
}

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
use PHPUnit\Framework\TestCase;

abstract class AbstractJsonSchemaTestCase extends TestCase
{
    abstract protected function getSchema(): AbstractJsonSchema;

    public function test_json_serialize()
    {
        $schema = $this->getSchema()->setId('id');

        $expected = 'id';
        $actual = $schema->jsonSerialize();
        $this->assertTrue(array_key_exists('$id', $actual));
        $this->assertSame($expected, $actual['$id']);
    }

    public function test_id()
    {
        $schema = $this->getSchema()->setId('id');

        $expected = 'id';
        $actual = $schema->toArray();
        $this->assertTrue(array_key_exists('$id', $actual));
        $this->assertSame($expected, $actual['$id']);
    }

    public function test_schema()
    {
        $schema = $this->getSchema()->setSchema('schema');

        $expected = 'schema';
        $actual = $schema->toArray();
        $this->assertTrue(array_key_exists('$schema', $actual));
        $this->assertSame($expected, $actual['$schema']);
    }

    public function test_comment()
    {
        $schema = $this->getSchema()->setComment('comment');

        $expected = 'comment';
        $actual = $schema->toArray();
        $this->assertTrue(array_key_exists('$comment', $actual));
        $this->assertSame($expected, $actual['$comment']);
    }

    public function test_title()
    {
        $schema = $this->getSchema()->setTitle('title');

        $expected = 'title';
        $actual = $schema->toArray();
        $this->assertTrue(array_key_exists('title', $actual));
        $this->assertSame($expected, $actual['title']);
    }

    public function test_description()
    {
        $schema = $this->getSchema()->setDescription('description');

        $expected = 'description';
        $actual = $schema->toArray();
        $this->assertTrue(array_key_exists('description', $actual));
        $this->assertSame($expected, $actual['description']);
    }

    public function test_default()
    {
        $schema = $this->getSchema()->setDefault('default');

        $expected = 'default';
        $actual = $schema->toArray();
        $this->assertTrue(array_key_exists('default', $actual));
        $this->assertSame($expected, $actual['default']);
    }

    public function test_examples()
    {
        $schema = $this->getSchema()->setExamples(['examples']);

        $expected = ['examples'];
        $actual = $schema->toArray();
        $this->assertTrue(array_key_exists('examples', $actual));
        $this->assertSame($expected, $actual['examples']);
    }

    public function test_readOnly()
    {
        $schema = $this->getSchema()->setReadOnly(true);

        $expected = true;
        $actual = $schema->toArray();
        $this->assertTrue(array_key_exists('readOnly', $actual));
        $this->assertSame($expected, $actual['readOnly']);
    }

    public function test_writeOnly()
    {
        $schema = $this->getSchema()->setWriteOnly(true);

        $expected = true;
        $actual = $schema->toArray();
        $this->assertTrue(array_key_exists('writeOnly', $actual));
        $this->assertSame($expected, $actual['writeOnly']);
    }

    public function test_deprecated()
    {
        $schema = $this->getSchema()->setDeprecated(true);

        $expected = true;
        $actual = $schema->toArray();
        $this->assertTrue(array_key_exists('deprecated', $actual));
        $this->assertSame($expected, $actual['deprecated']);
    }
}

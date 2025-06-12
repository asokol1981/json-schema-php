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

use ASokol1981\JsonSchema\Draft07\RefSchema;
use PHPUnit\Framework\TestCase;

class RefSchemaTest extends TestCase
{
    public function test()
    {
        $schema = new RefSchema('#/definitions/');
        $expected = ['$ref' => '#/definitions/'];

        $this->assertSame($expected, $schema->toArray());
    }
}

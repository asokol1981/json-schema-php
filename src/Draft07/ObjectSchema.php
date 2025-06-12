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

class ObjectSchema extends AbstractJsonSchema
{
    /** @var array<string, JsonSchemaInterface> */
    protected array $properties = [];

    /** @var string[] */
    protected array $required = [];

    /** @var int|null */
    protected ?int $maxProperties = null;

    /** @var int|null */
    protected ?int $minProperties = null;

    /** @var array<string, JsonSchemaInterface> */
    protected array $patternProperties = [];

    /** @var JsonSchemaInterface|null */
    protected ?JsonSchemaInterface $propertyNames = null;

    /** @var JsonSchemaInterface|null */
    protected ?JsonSchemaInterface $additionalProperties = null;

    /** @var array<string, JsonSchemaInterface> */
    protected array $definitions = [];

    /** @var array<string, array<string>|JsonSchemaInterface> */
    protected array $dependencies = [];

    /**
     * @param array<string, JsonSchemaInterface|bool> $properties
     */
    public function __construct(array|bool $properties = [])
    {
        foreach ($properties as $name => $property) {
            $this->addProperty($name, $property);
        }
    }

    /**
     * @param string $name
     * @param JsonSchemaInterface|bool $property
     * @return $this
     */
    public function addProperty(string $name, JsonSchemaInterface|bool $property): static
    {
        if (is_bool($property)) {
            $property = $property ? new TrueSchema() : new FalseSchema();
        }
        $this->properties[$name] = $property;
        return $this;
    }

    /**
     * @param array|string $required
     * @return $this
     */
    public function setRequired(array|string $required): static
    {
        foreach(is_array($required) ? $required : func_get_args() as $name) {
            $this->addRequired($name);
        }
        return $this;
    }

    /**
     * @param string $name
     * @return $this
     */
    public function addRequired(string $name): static
    {
        $this->required[] = $name;
        return $this;
    }

    /**
     * @param int $maxProperties
     * @return $this
     */
    public function setMaxProperties(int $maxProperties): static
    {
        if ($maxProperties < 0) {
            throw new \InvalidArgumentException('maxProperties must be greater than 0');
        }
        $this->maxProperties = $maxProperties;
        return $this;
    }

    /**
     * @param int $minProperties
     * @return $this
     */
    public function setMinProperties(int $minProperties): static
    {
        if ($minProperties < 0) {
            throw new \InvalidArgumentException('minProperties must be greater than 0');
        }
        $this->minProperties = $minProperties;
        return $this;
    }

    /**
     * @param array<string, JsonSchemaInterface|bool> $patternProperties
     * @return $this
     */
    public function setPatternProperties(array $patternProperties): static
    {
        foreach($patternProperties as $pattern => $property) {
            $this->addPatternProperty($pattern, $property);
        }
        return $this;
    }

    /**
     * @param string $pattern
     * @param JsonSchemaInterface|bool $property
     * @return $this
     */
    public function addPatternProperty(string $pattern, JsonSchemaInterface|bool $property): static
    {
        if (is_bool($property)) {
            $property = $property ? new TrueSchema() : new FalseSchema();
        }
        $this->patternProperties[$pattern] = $property;
        return $this;
    }

    /**
     * @param JsonSchemaInterface|bool $propertyNames
     * @return $this
     */
    public function setPropertyNames(JsonSchemaInterface|bool $propertyNames): static
    {
        if (is_bool($propertyNames)) {
            $propertyNames = $propertyNames ? new TrueSchema() : new FalseSchema();
        }
        $this->propertyNames = $propertyNames;
        return $this;
    }

    /**
     * @param JsonSchemaInterface|bool $value
     * @return $this
     */
    public function setAdditionalProperties(JsonSchemaInterface|bool $additionalProperties): static
    {
        if (is_bool($additionalProperties)) {
            $additionalProperties = $additionalProperties ? new TrueSchema() : new FalseSchema();
        }
        $this->additionalProperties = $additionalProperties;
        return $this;
    }

    /**
     * @param array<string, JsonSchemaInterface|bool> $definitions
     * @return $this
     */
    public function setDefinitions(array $definitions): static
    {
        foreach($definitions as $name => $definition) {
            $this->addDefinition($name, $definition);
        }
        return $this;
    }

    /**
     * @param string $name
     * @param JsonSchemaInterface|bool $schema
     * @return $this
     */
    public function addDefinition(string $name, JsonSchemaInterface|bool $schema): static
    {
        if (is_bool($schema)) {
            $schema = $schema ? new TrueSchema() : new FalseSchema();
        }
        $this->definitions[$name] = $schema;
        return $this;
    }

    /**
     * @param array<string, array<string>|JsonSchemaInterface|bool> $dependencies
     * @return $this
     */
    public function setDependencies(array $dependencies): static
    {
        foreach($dependencies as $name => $dependency) {
            $this->addDependency($name, $dependency);
        }
        return $this;
    }

    /**
     * @param string $name
     * @param array<string>|JsonSchemaInterface|bool $dependency
     * @return $this
     */
    public function addDependency(string $name, array|JsonSchemaInterface|bool $dependency): static
    {
        if (is_bool($dependency)) {
            $dependency = $dependency ? new TrueSchema() : new FalseSchema();
        }
        $this->dependencies[$name] = $dependency;
        return $this;
    }

    /**
     * @param array $schema
     * @return array
     */
    public function toArray(): array|bool
    {
        $schema = $this->applyProperties(
            [
                'type' => 'object',
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
                // object
                'minProperties',
                'maxProperties',
                'propertyNames',
                'additionalProperties',
            ],
        );
        if ($this->properties) {
            $schema['properties'] = array_map(fn($property) => $property->toArray(), $this->properties);
        }
        if ($this->patternProperties) {
            $schema['patternProperties'] = array_map(fn($property) => $property->toArray(), $this->patternProperties);
        }
        if ($this->definitions) {
            $schema['definitions'] = array_map(fn($definition) => $definition->toArray(), $this->definitions);
        }
        if ($this->dependencies) {
            $schema['dependencies'] = array_map(fn($dependency) => ($dependency instanceof JsonSchemaInterface) ? $dependency->toArray() : $dependency, $this->dependencies);
        }
        if ($this->required) {
            $schema['required'] = $this->required;
        }
        return $schema;
    }
}

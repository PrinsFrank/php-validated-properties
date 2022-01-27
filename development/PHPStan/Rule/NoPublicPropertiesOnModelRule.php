<?php
declare(strict_types=1);

namespace PrinsFrank\PhpStrictModels\Development\PHPStan\Rule;

use PhpParser\Node;
use PHPStan\Analyser\Scope;
use PHPStan\Node\ClassPropertiesNode;
use PHPStan\Rules\Rule;
use PrinsFrank\PhpStrictModels\Model;

/**
 * @implements Rule<ClassPropertiesNode>
 */
class NoPublicPropertiesOnModelRule implements Rule
{
    public function getNodeType(): string
    {
        return ClassPropertiesNode::class;
    }

    public function processNode(Node $node, Scope $scope): array
    {
        if (in_array(Model::class, $scope->getClassReflection()?->getParentClassesNames() ?? [], true) === false) {
            return [];
        }

        /** @var ClassPropertiesNode $node */
        $errors = [];
        foreach ($node->getProperties() as $property) {
            if ($property->isPublic()) {
                $errors[] = 'Models of type ' . Model::class . ' Should not have public properties, public $' . $property->getName() . ' defined';
            }
        }

        return $errors;
    }
}

<?php declare(strict_types=1);

namespace App\Entity;

use Othyn\PhpEnumEnhancements\Traits\EnumEnhancements;
use ReflectionClass;

enum QuizTypes: string
{
    use EnumEnhancements;

    case MULTIPLE_CHOICE = 'MultipleChoice';
    case DRAG_AND_DROP_Group = 'DragDropGroup';
    case DRAG_AND_DROP_WORDS = 'DragDropWords';
    case TYPE_MISSING_WORDS = 'TypeMissingWords';
    case FIND_WRONG_WORDS = 'FindWrongWords';

    /**
     * @throws \ReflectionException
     */
    public function getEnumChoices(): array
    {
        $reflectionClass = new ReflectionClass(QuizTypes::class);
        $enumConstants = $reflectionClass->getConstants();

        $choices = [];
        foreach ($enumConstants as $constantName => $constantValue) {
            $choices[$constantName] = $constantValue;
        }

        return $choices;
    }
}
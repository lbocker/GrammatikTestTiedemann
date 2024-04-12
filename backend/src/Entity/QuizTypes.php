<?php declare(strict_types=1);

namespace App\Entity;

enum QuizTypes: string
{
    case MULTIPLE_CHOICE = 'MULTIPLE_CHOICE';
    case DRAG_AND_DROP_GROUP = 'DRAG_AND_DROP_GROUP';
    case DRAG_AND_DROP_WORDS = 'DRAG_AND_DROP_WORDS';
    case TYPE_MISSING_WORDS = 'TYPE_MISSING_WORDS';
    case FIND_WRONG_WORDS = 'FIND_WRONG_WORDS';
}
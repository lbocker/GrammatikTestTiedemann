<?php

namespace App\Controller\Admin;

use App\Entity\Quiz;
use App\Entity\QuizTypes;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class QuizCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Quiz::class;
    }

    /**
     * @throws \ReflectionException
     */
    public function configureFields(string $pageName, ): iterable
    {
        yield ChoiceField::new('type')->setChoices(
            QuizTypes::class->getEnumChoices()
        )->autocomplete(true);
        yield TextField::new('question');
        yield TextField::new('rightAnswer');
        yield TextField::new('wrongAnswer');
    }
}
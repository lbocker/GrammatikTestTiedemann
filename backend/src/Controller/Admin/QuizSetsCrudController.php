<?php

namespace App\Controller\Admin;

use App\Entity\QuizSets;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class QuizSetsCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return QuizSets::class;
    }

    public function configureFields(string $pageName): iterable
    {
        yield TextField::new('title');
        yield TextField::new('description');
        yield CollectionField::new('quizzes')->useEntryCrudForm(
            QuizCrudController::class,
        );
    }
}

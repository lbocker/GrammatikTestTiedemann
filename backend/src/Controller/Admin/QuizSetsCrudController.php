<?php

namespace App\Controller\Admin;

use App\Entity\QuizSets;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use function Symfony\Component\Translation\t;

class QuizSetsCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return QuizSets::class;
    }


    public function configureFields(string $pageName): iterable
    {
        yield TextField::new('title', t('quiz_set.title'))->setRequired(true);
        yield TextareaField::new('description', t('quiz_set.description'))->setRequired(true);
        yield CollectionField::new('quizzes', t('quiz_set.quizzes'))->useEntryCrudForm(
            QuizCrudController::class, 'new_quiz_sets_page', 'edit_quiz_sets_page',
        );
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInPlural(t('dashboard.quiz_sets'))
            ->renderContentMaximized();
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->update(Crud::PAGE_INDEX, Action::NEW, function (Action $action) {
                return $action->setLabel('quiz_set.new_quiz_set');
            })
            ->update(Crud::PAGE_INDEX, Action::EDIT, function (Action $action) {
                return $action->setLabel('quiz_set.edit_quiz_set');
            })
            ->update(Crud::PAGE_INDEX, Action::DELETE, function (Action $action) {
                return $action->setLabel('quiz_set.delete_quiz_set');
            })
            ->update(Crud::PAGE_NEW, Action::SAVE_AND_ADD_ANOTHER, function (Action $action) {
                return $action->setLabel('quiz_set.save_and_add_another');
            })
            ->update(Crud::PAGE_EDIT, Action::SAVE_AND_CONTINUE, function (Action $action) {
                return $action->setLabel('quiz_set.save_and_continue');
            });
    }
}

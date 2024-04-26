<?php

namespace App\Controller\Admin;

use App\Entity\Quiz;
use App\Entity\QuizTypes;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use function Symfony\Component\Translation\t;

class QuizCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Quiz::class;
    }

    public function configureFields(string $pageName): iterable
    {
        yield ChoiceField::new('type', t('quiz.type.name'))->setChoices(
            function () {
                $types = [];
                foreach (QuizTypes::cases() as $type) {
                    $types["quiz.type.options.$type->value"] = $type->name;
                }
                return $types;
            }
        )->autocomplete()->setRequired(true);
        yield TextField::new('question', t('quiz.question'))->setRequired(true);
        yield ArrayField::new('rightAnswer', t('quiz.right_answer'))->setRequired(true);
        yield ArrayField::new('wrongAnswer', t('quiz.wrong_answer'))->setRequired(true);
        yield NumberField::new('points', t('quiz.points'))->setRequired(true);
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInPlural(t('dashboard.quizzes'))
            ->renderContentMaximized();
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->update(Crud::PAGE_INDEX, Action::NEW, function (Action $action) {
                return $action->setLabel('quiz.new_quiz');
            })
            ->update(Crud::PAGE_INDEX, Action::EDIT, function (Action $action) {
                return $action->setLabel('quiz.edit_quiz');
            })
            ->update(Crud::PAGE_INDEX, Action::DELETE, function (Action $action) {
                return $action->setLabel('quiz.delete_quiz');
            })
            ->update(Crud::PAGE_NEW, Action::SAVE_AND_ADD_ANOTHER, function (Action $action) {
                return $action->setLabel('quiz.save_and_add_another');
            })
            ->update(Crud::PAGE_EDIT, Action::SAVE_AND_CONTINUE, function (Action $action) {
                return $action->setLabel('quiz.save_and_continue');
            });
    }
}
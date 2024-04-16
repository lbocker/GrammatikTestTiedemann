<?php

namespace App\Controller\Admin;

use App\Entity\Courses;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use function Symfony\Component\Translation\t;

class CoursesCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Courses::class;
    }

    public function configureFields(string $pageName): iterable
    {
        yield TextField::new('title', t('courses.title'))->setMaxLength(255)->setRequired(true);
        yield TextareaField::new('description', t('courses.description'))->setMaxLength(255);
        yield ImageField::new('image', t('courses.image'))->setUploadDir('public/uploads/images/courses')->setBasePath('uploads/images/courses')->setUploadedFileNamePattern('[year]-[month]-[day]-[timestamp]-[slug]-[contenthash].[extension]');
        yield CollectionField::new('quizSets', t('courses.quiz_sets'))->useEntryCrudForm(
            QuizSetsCrudController::class, 'new_quiz_sets_page', 'edit_quiz_sets_page',
        )->setEntryIsComplex();
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInPlural('dashboard.courses')
            ->renderContentMaximized();
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->update(Crud::PAGE_INDEX, Action::NEW, function (Action $action) {
                return $action->setLabel('courses.new_course');
            })
            ->update(Crud::PAGE_INDEX, Action::EDIT, function (Action $action) {
                return $action->setLabel('courses.edit_course');
            })
            ->update(Crud::PAGE_INDEX, Action::DELETE, function (Action $action) {
                return $action->setLabel('courses.delete_course');
            })
            ->update(Crud::PAGE_NEW, Action::SAVE_AND_ADD_ANOTHER, function (Action $action) {
                return $action->setLabel('courses.save_and_add_another');
            })
            ->update(Crud::PAGE_EDIT, Action::SAVE_AND_CONTINUE, function (Action $action) {
                return $action->setLabel('courses.save_and_continue');
            });
    }

}

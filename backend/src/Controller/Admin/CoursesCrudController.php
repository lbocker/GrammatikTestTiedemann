<?php

namespace App\Controller\Admin;

use App\Entity\Courses;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class CoursesCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Courses::class;
    }

    public function configureFields(string $pageName): iterable
    {
        yield TextField::new('title');
        yield TextareaField::new('description');
        yield ImageField::new('image')->setUploadDir('public/uploads/images/courses')->setBasePath('courses')->setUploadedFileNamePattern('[year]/[month]/[day]/[slug]-[contenthash].[extension]');
        yield CollectionField::new('quizSets')->useEntryCrudForm(
            QuizSetsCrudController::class, 'new_quiz_sets_page', 'edit_quiz_sets_page',
        );
    }
}

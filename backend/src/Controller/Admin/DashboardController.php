<?php

namespace App\Controller\Admin;

use App\Entity\Course;
use App\Entity\Quiz;
use App\Entity\QuizSets;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        return $this->redirect($adminUrlGenerator->setController(CourseCrudController::class)->generateUrl());
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Grammerjourney');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToCrud('Courses', 'fas fa-list', Course::class);
        yield MenuItem::linkToCrud('QuizSets', 'fas fa-list', QuizSets::class);
        yield MenuItem::linkToCrud('Quiz', 'fas fa-list', Quiz::class);
        yield MenuItem::linkToCrud('User', 'fas fa-list', User::class);
    }

}

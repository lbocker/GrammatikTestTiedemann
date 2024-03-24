<?php

namespace App\Controller\Admin;

use App\Entity\Courses;
use App\Entity\Quiz;
use App\Entity\QuizSets;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\UserMenu;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

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
         return $this->redirect($adminUrlGenerator->setController(CoursesCrudController::class)->generateUrl());
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Grammerjourney | Admin Dashboard')
            ->setFaviconPath('localhost:8000/public/favicon.ico');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Courses', 'fa fa-home', Courses::class);
        yield MenuItem::linkToCrud('QuizSets', 'fas fa-list', QuizSets::class);
        yield MenuItem::linkToCrud('Quiz', 'fas fa-list', Quiz::class);
        yield MenuItem::linkToCrud('User', 'fas fa-user', User::class)->setPermission('ROLE_ADMIN');
        yield MenuItem::linkToUrl('API Docs', 'fas fa-book', '/api/doc')->setPermission('ROLE_ADMIN');
    }

    public function configureUserMenu(UserInterface $user): UserMenu
    {
        return parent::configureUserMenu($user)
            ->setName($user->getUserIdentifier())
            ->displayUserName(true)
            ->displayUserAvatar(true)
            ->addMenuItems([
                MenuItem::linkToRoute('Back to the website', 'fas fa-home', 'dashboard'),
                MenuItem::linkToLogout('Logout', 'fa fa-sign-out'),
            ]);
    }
}

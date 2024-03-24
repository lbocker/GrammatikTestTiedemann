<?php

namespace App\Controller\Admin;

use App\Entity\Courses;
use App\Entity\Quiz;
use App\Entity\QuizSets;
use App\Entity\User;
use App\Service\UserService;
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
use function Symfony\Component\Translation\t;

class DashboardController extends AbstractDashboardController
{
    public function __construct(private readonly UserService $userService) {}

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    #[Route('/admin/{_locale}', name: 'admin', locale: 'en_US, de_De, pt_BR')]
    public function index(): Response
    {
         $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
         return $this->redirect($adminUrlGenerator->setController(CoursesCrudController::class)->generateUrl());
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setFaviconPath('/uploads/images/favicon.ico')
            ->setTranslationDomain('messages')
            ->setTitle(t('Grammerjourney | Admin Dashboard'))
            ->setLocales([
                'en' => 'English',
                'de' => 'Deutsch',
                'br' => 'Português do Brasil',
                'fr' => 'Français',
            ])
            ->setTextDirection('ltr');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard(t('dashboard.courses'), 'fa fa-home', Courses::class);
        yield MenuItem::linkToCrud(t('dashboard.quiz_sets'), 'fas fa-list', QuizSets::class);
        yield MenuItem::linkToCrud(t('dashboard.quizzes'), 'fas fa-list', Quiz::class);
        yield MenuItem::linkToCrud(t('dashboard.user'), 'fas fa-user', User::class)->setPermission('ROLE_ADMIN');
        yield MenuItem::linkToUrl(t('dashboard.api_docs'), 'fas fa-book', '/api/doc')->setPermission('ROLE_ADMIN');
    }

    public function configureUserMenu(UserInterface $user): UserMenu
    {
        $userImage = $this->userService->getUserByEmail($user->getUserIdentifier())->getImage();

        return UserMenu::new()
            ->setName($user->getUserIdentifier())
            ->displayUserName(true)
            ->displayUserAvatar(true)
            ->setAvatarUrl($userImage ? '/uploads/images/user/' . $userImage : 'https://http.cat/status/404.jpg')
            ->addMenuItems([
                MenuItem::linkToRoute(t('settings.home'), 'fas fa-home', 'dashboard'),
                MenuItem::section(),
                MenuItem::linkToLogout('settings.logout', 'fa fa-sign-out'),
            ]);
    }
}

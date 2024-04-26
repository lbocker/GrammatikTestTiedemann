<?php

namespace App\Events;

use App\Controller\API\CoursesController;
use App\Controller\API\UserController;
use App\Entity\Courses;
use App\Entity\CoursesStatus;
use App\Entity\User;
use App\Entity\UserCoursesStatus;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Symfony\Component\HttpKernel\KernelEvents;

readonly class StatusUpdater implements EventSubscriberInterface
{
    public function __construct(private EntityManagerInterface $entityManager) { }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::CONTROLLER => 'onControllerEvent',
        ];
    }

    /* Create a method that set automatically the status of the Course for the User, when a new User or Course was Created */
    public function onControllerEvent(ControllerEvent $event): void
    {
        $controller = $event->getController();
        if (!is_array($controller)) {
            return;
        }

        $controller = $controller[0];
        if ($controller instanceof UserController) {
            $this->updateUserCoursesStatus();
        }

        if ($controller instanceof CoursesController) {
            $this->updateUserCoursesStatus();
        }
    }

    private function updateUserCoursesStatus(): void
    {
        $users = $this->entityManager->getRepository(User::class)->findAll();
        $courses = $this->entityManager->getRepository(Courses::class)->findAll();

        foreach ($users as $user) {
            foreach ($courses as $course) {
                $userCoursesStatus = new UserCoursesStatus();
                $userCoursesStatus->setUserId($user);
                $userCoursesStatus->setCoursesId($course);
                $userCoursesStatus->setStatus(CoursesStatus::OPEN);

                $this->entityManager->persist($userCoursesStatus);
            }
        }

        $this->entityManager->flush();
    }
}
<?php

namespace App\Controller;

use App\Entity\User;
use App\QueryObject\GetGroups;
use App\QueryObject\GetNotifications;
use App\QueryObject\GetUnreadNotificationsCount;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class IndexController
 */
class IndexController extends AbstractController
{
    /** @var LoggerInterface */
    private $logger;

    /** @var GetGroups */
    private $getGroups;

    /** @var GetNotifications */
    private $getNotifications;

    /** @var GetUnreadNotificationsCount */
    private $getUnreadNotificationsCount;

    public function __construct(
        LoggerInterface $logger,
        GetGroups $getGroups,
        GetNotifications $getNotifications,
        GetUnreadNotificationsCount $getUnreadNotificationsCount
    ) {
        $this->getGroups                   = $getGroups;
        $this->getNotifications            = $getNotifications;
        $this->getUnreadNotificationsCount = $getUnreadNotificationsCount;
        $this->logger                      = $logger;
    }

    /**
     * @param Request $request
     *
     * @return Response
     */
    public function __invoke(Request $request)
    {
        try {
            /** @var User $user */
            $user   = $this->getUser();
            $params = [
                'search'     => $request->query->get('search'),
                'isMyGroups' => $request->query->get('myGroups'),
            ];

            $groups                   = $this->getGroups->execute($params, $user);
            $notifications            = $this->getNotifications->execute($user);
            $unreadNotificationsCount = $this->getUnreadNotificationsCount->execute($user);

            return $this->render('index.html.twig', [
                'groups'                   => $groups,
                'notifications'            => $notifications,
                'unreadNotificationsCount' => $unreadNotificationsCount,
            ]);
        } catch (\Throwable $exception) {
            $this->logger->error($exception->getMessage());

            return new JsonResponse('error.unexpectedError', JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}

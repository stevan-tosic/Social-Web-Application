<?php

namespace App\Controller\Group;

use App\Entity\Group;
use App\Service\GroupJoinRequestService;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class ShowMembersListAction
 */
class ShowMembersListAction extends AbstractController
{
    /** @var LoggerInterface */
    private $logger;

    /** @var GroupJoinRequestService */
    private $joinRequest;

    public function __construct(
        LoggerInterface $logger,
        GroupJoinRequestService $joinRequest
    ) {
        $this->joinRequest = $joinRequest;
        $this->logger      = $logger;
    }

    /**
     * @param Group $group
     *
     * @return Response
     */
    public function __invoke(Group $group)
    {
        try {
            return $this->render('group/show_member_list.html.twig', [
                'members' => $group->getMembers(),
            ]);
        } catch (\Throwable $exception) {
            $this->logger->error($exception->getMessage());

            return new JsonResponse('error.unexpectedError', JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}

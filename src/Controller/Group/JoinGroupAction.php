<?php

namespace App\Controller\Group;

use App\Entity\Group;
use App\Entity\User;
use App\Service\CreateGroupService;
use App\Service\GroupJoinRequestService;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class JoinGroupAction
 */
class JoinGroupAction extends AbstractController
{
    /** @var LoggerInterface */
    private $logger;

    /** @var CreateGroupService */
    private $createGroup;

    /** @var GroupJoinRequestService */
    private $groupJoinRequest;

    public function __construct(
        LoggerInterface $logger,
        CreateGroupService $createGroup,
        GroupJoinRequestService $groupJoinRequest
    ) {
        $this->createGroup      = $createGroup;
        $this->groupJoinRequest = $groupJoinRequest;
        $this->logger           = $logger;
    }

    /**
     * @param Request $request
     * @param Group   $group
     *
     * @return Response
     */
    public function __invoke(Request $request, Group $group)
    {
        try {
            /** @var User $user */
            $user = $this->getUser();
            $this->groupJoinRequest->execute($user, $group);

            return new JsonResponse(['joined' => true], JsonResponse::HTTP_CREATED);
        } catch (\Throwable $exception) {
            $this->logger->error($exception->getMessage());

            return new JsonResponse('error.unexpectedError', JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}

<?php

namespace App\Controller\Group;

use App\Entity\GroupJoinRequest;
use App\Service\GroupJoinRequestService;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class RefuseJoinRequestAction
 */
class RefuseJoinRequestAction extends AbstractController
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
     * @param GroupJoinRequest $joinRequest
     *
     * @return Response
     */
    public function __invoke(GroupJoinRequest $joinRequest)
    {
        try {
            $this->joinRequest->refuse($joinRequest);

            return new JsonResponse(['refused' => true], JsonResponse::HTTP_NO_CONTENT);
        } catch (\Throwable $exception) {
            $this->logger->error($exception->getMessage());

            return new JsonResponse('error.unexpectedError', JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}

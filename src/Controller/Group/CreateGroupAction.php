<?php

namespace App\Controller\Group;

use App\Entity\Group;
use App\Entity\User;
use App\Form\GroupType;
use App\Service\CreateGroupService;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class CreateGroupAction
 */
class CreateGroupAction extends AbstractController
{
    /** @var LoggerInterface */
    private $logger;

    /** @var CreateGroupService */
    private $createGroup;

    public function __construct(
        LoggerInterface $logger,
        CreateGroupService $createGroup
    ) {
        $this->createGroup = $createGroup;
        $this->logger      = $logger;
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
            $user = $this->getUser();

            $form = $this->createForm(GroupType::class, new Group());
            $form->handleRequest($request);

            if ($request->isMethod('POST')) {
                $formData = $request->request->get('group');
                $this->createGroup->execute($user, $formData);

                $this->addFlash('success', 'Group Successfully Created');

                return new JsonResponse(['added' => true], JsonResponse::HTTP_CREATED);
            }

            return $this->render('group/group.html.twig', [
                'form' => $form->createView(),
            ]);
        } catch (\Throwable $exception) {
            $this->logger->error($exception->getMessage());

            return new JsonResponse('error.unexpectedError', JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}

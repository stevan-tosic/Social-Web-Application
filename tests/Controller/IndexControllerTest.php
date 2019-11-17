<?php

namespace App\Tests\TestCase;

use App\Controller\IndexController;
use App\QueryObject\GetGroups;
use App\QueryObject\GetNotifications;
use App\QueryObject\GetUnreadNotificationsCount;
use Prophecy\Argument;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Request;

abstract class IndexControllerTest extends ControllerTestCase
{
    private $instance;

    /** @var LoggerInterface */
    private $logger;

    /** @var GetGroups */
    private $getGroups;

    /** @var GetNotifications */
    private $getNotifications;

    /** @var GetUnreadNotificationsCount */
    private $getUnreadNotificationsCount;

    /** @var Request $request */
    private $request;

    public function setUp()
    {
        parent::setUp();

        $this->request = $this->prophesize(Request::class);
        $this->logger = $this->prophesize(LoggerInterface::class);
        $this->getGroups = $this->prophesize(GetGroups::class);
        $this->getNotifications = $this->prophesize(GetNotifications::class);
        $this->getUnreadNotificationsCount = $this->prophesize(GetUnreadNotificationsCount::class);

        $this->request->getContent(Argument::any())->willReturn('{"a":"b"}');

        $controllerInstance = new IndexController(
            $this->logger->reveal(),
            $this->getGroups->reveal(),
            $this->getNotifications->reveal(),
            $this->getUnreadNotificationsCount->reveal()
        );
        $controllerInstance->setContainer($this->container->reveal());

        $this->instance = $controllerInstance;
    }

    public function testInvoke()
    {
        // TODO
    }

}

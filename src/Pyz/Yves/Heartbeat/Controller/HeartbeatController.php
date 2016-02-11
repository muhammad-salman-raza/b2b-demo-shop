<?php

namespace Pyz\Yves\Heartbeat\Controller;

use Spryker\Yves\Application\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 * @method \Pyz\Yves\Heartbeat\HeartbeatFactory getFactory()
 */
class HeartbeatController extends AbstractController
{

    const SYSTEM_UP = 'UP';
    const SYSTEM_DOWN = 'DOWN';
    const SYSTEM_STATUS = 'status';
    const STATUS_REPORT = 'report';

    /**
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function indexAction()
    {
        $healthChecker = $this->getFactory()->createHealthChecker();

        if ($healthChecker->doHealthCheck()->isSystemAlive()) {
            return $this->jsonResponse(
                [
                    self::SYSTEM_STATUS => self::SYSTEM_UP,
                ],
                Response::HTTP_OK
            );
        }

        return $this->jsonResponse(
            [
                self::SYSTEM_STATUS => self::SYSTEM_DOWN,
                self::STATUS_REPORT => $healthChecker->doHealthCheck()->getReport()->toArray(),
            ],
            Response::HTTP_SERVICE_UNAVAILABLE
        );
    }

}

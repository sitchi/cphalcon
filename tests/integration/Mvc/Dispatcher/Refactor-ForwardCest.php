<?php

namespace Phalcon\Test\Integration\Mvc\Dispatcher;

use IntegrationTester;
use Phalcon\Di\FactoryDefault;
use Phalcon\Events\Manager;
use Phalcon\Mvc\Application;
use Phalcon\Mvc\Dispatcher;
use Phalcon\Mvc\View;
use function dataFolder;

/**
 * \Phalcon\Test\Integration\Mvc\Dispatcher\ForwardCest
 * Tests the Phalcon\Mvc\Dispatcher
 *
 * @copyright (c) 2011-2017 Phalcon Team
 * @link          http://www.phalconphp.com
 * @author        Phalcon Team <team@phalconphp.com>
 * @package       Phalcon\Test\Integration\Mvc\Dispatcher
 *
 * The contents of this file are subject to the New BSD License that is
 * bundled with this package in the file LICENSE.txt
 *
 * If you did not receive a copy of the license and are unable to obtain it
 * through the world-wide-web, please send an email to license@phalconphp.com
 * so that we can send you a copy immediately.
 */
class RefactorForwardCest
{
    /**
     * @issue https://github.com/phalcon/cphalcon/issues/11819
     * @param IntegrationTester $I
     */
    public function handlingException(IntegrationTester $I)
    {
        $di = new FactoryDefault();
        $di->set('view', function () {
            $view = new View();
            $view->setViewsDir(dataFolder('fixtures/views/'));

            return $view;
        }, true);

        $eventsManager = new Manager();

        $eventsManager->attach('dispatch:beforeException', function ($event, $dispatcher, $exception) {
            $dispatcher->forward([
                'controller' => 'exception',
                'action'     => 'second',
            ]);

            // Prevent the exception from bubbling
            return false;
        });

        $dispatcher = new Dispatcher();
        $dispatcher->setEventsManager($eventsManager);

        $di->setShared('dispatcher', $dispatcher);

        $application = new Application();
        $application->setEventsManager(new Manager());
        $application->setDI($di);

        $response = $application->handle("/exception");
        $I->assertSame("I should be displayed", $response->getContent());
    }
}

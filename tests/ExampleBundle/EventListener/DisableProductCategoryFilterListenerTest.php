<?php

namespace ExampleBundle\Tests\EventListener;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Query\FilterCollection;
use ExampleBundle\EventListener\DisableProductCategoryFilterListener;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class DisableProductCategoryFilterListenerTest extends WebTestCase
{
    public function testNotDisable()
    {
        $em = $this->prophesize(EntityManagerInterface::class);
        $authChecker = $this->prophesize(AuthorizationCheckerInterface::class);
        $filterCollection = $this->prophesize(FilterCollection::class);

        $listener = new DisableProductCategoryFilterListener(
            $em->reveal(),$authChecker->reveal()
        );

        $authChecker->isGranted('ROLE_ADMIN')
            ->willReturn(false)
            ->shouldBeCalled();

        $filterCollection
            ->disable('active_product_category')
            ->shouldNotBeCalled();

        $em->getFilters()
            ->willReturn($filterCollection->reveal())
            ->shouldNotBeCalled();

        $event = $this->prophesize(GetResponseEvent::class);
        $event->getRequest()->willReturn(Request::create('/'));

        $result = $listener->onKernelRequest($event->reveal());

        $this->assertFalse($result);
    }

    public function testDisable()
    {
        $em = $this->prophesize(EntityManagerInterface::class);
        $authChecker = $this->prophesize(AuthorizationCheckerInterface::class);
        $filterCollection = $this->prophesize(FilterCollection::class);

        $listener = new DisableProductCategoryFilterListener(
            $em->reveal(),$authChecker->reveal()
        );

        $authChecker->isGranted('ROLE_ADMIN')
            ->willReturn(true)
            ->shouldBeCalled();

        $filterCollection
            ->disable('active_product_category')
            ->shouldBeCalled();

        $em->getFilters()
            ->willReturn($filterCollection->reveal())
            ->shouldBeCalled();

        $event = $this->prophesize(GetResponseEvent::class);
        $event->getRequest()->willReturn(Request::create('/'));

        $result = $listener->onKernelRequest($event->reveal());

        $this->assertTrue($result);

    }

    public function testReturnOnNotSecuredPath()
    {
        $em = $this->prophesize(EntityManagerInterface::class);
        $authChecker = $this->prophesize(AuthorizationCheckerInterface::class);
        $filterCollection = $this->prophesize(FilterCollection::class);

        $listener = new DisableProductCategoryFilterListener(
            $em->reveal(),$authChecker->reveal()
        );

        $event = $this->prophesize(GetResponseEvent::class);
        $event->getRequest()->willReturn(Request::create('/_profiler/'));

        $authChecker->isGranted('ROLE_ADMIN')->shouldNotBeCalled();

        $result = $listener->onKernelRequest($event->reveal());

        $this->assertNull($result);
    }
}
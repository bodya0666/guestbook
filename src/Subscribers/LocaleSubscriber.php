<?php
namespace App\Subscribers;
//use mysql_xdevapi\Exception;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;
class LocaleSubscriber implements EventSubscriberInterface
{
    private $defautlLocale;
    public function __construct(string $defaultLocale = "en")
    {
        $this->defautlLocale = $defaultLocale;
    }
    public function onKernelRequest(GetResponseEvent $event)
    {
        $request = $event->getRequest();
        if (is_string($request->cookies->get('lang'))){
            $request->setLocale($request->cookies->get('lang'));
        } else {
            $request->setLocale('en');
        }
    }
    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::REQUEST => [['onKernelRequest', 17]]
        ];
    }
}
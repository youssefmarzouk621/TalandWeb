<?php
namespace CalendarZiedBundle\EventListener;

use ADesigns\CalendarBundle\Event\CalendarEvent;
use ADesigns\CalendarBundle\Entity\EventEntity;
use CalendarZiedBundle\Entity\deals;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class CalendarEventListener
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function loadEvents(CalendarEvent $calendarEvent)
    {
        $startDate = $calendarEvent->getStartDatetime();
        $endDate = $calendarEvent->getEndDatetime();

        // The original request so you can get filters from the calendar
        // Use the filter in your query for example

        $request = $calendarEvent->getRequest();
        $filter = $request->get('filter');


        // load events using your custom logic here,
        // for instance, retrieving events from a repository

        $companyEvents = $this->entityManager->getRepository(deals::class)
            ->createQueryBuilder('deals')
            ->getQuery()->getResult();

        // $companyEvents and $companyEvent in this example
        // represent entities from your database, NOT instances of EventEntity
        // within this bundle.
        //
        // Create EventEntity instances and populate it's properties with data
        // from your own entities/database values.
        $foo=0;
        foreach($companyEvents as $companyEvent) {
            $foo=$foo+1;
            $color='';
            switch ($foo) {
                case 1:
                    $color='#355C7D';
                    break;
                case 2:
                    $color='#FB6E52';
                    break;
                case 3:
                    $color='#50C1E9';
                    break;
                case 4:
                    $color='#48CFAE';
                    break;
                case 5:
                    $color='#ED5564';
                    break;
                case 6:
                    $color='#F8B195';
                    break;
                case 7:
                    $color='#6C5B7B';
                    break;
                case 8:
                    $color='#2D95BF';
                    break;
                case 9:
                    $color='#547A8B';
                    break;
                case 10:
                    $color='#3EACAB';
                    $foo=0;
                    break;
            }


            // create an event with a start/end time, or an all day event

                $eventEntity = new EventEntity($companyEvent->getEventdescription(), $companyEvent->getStart(), $companyEvent->getEnd(),false);

            //optional calendar event settings
            $eventEntity->setAllDay(true); // default is false, set to true if this is an all day event
            $eventEntity->setBgColor($color); //set the background color of the event's label
            $eventEntity->setFgColor('#FFFFFF'); //set the foreground color of the event's label
            $eventEntity->setCssClass('my-custom-class'); // a custom class you may want to apply to event labels

            
            //finally, add the event to the CalendarEvent for displaying on the calendar
            $calendarEvent->addEvent($eventEntity);
        }
    }



}
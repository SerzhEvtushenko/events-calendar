<?php

namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class UpdateEventsCommand extends ContainerAwareCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->setName('app:update_events');
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $em       = $this->getContainer()->get('doctrine')->getManager();
        $accounts = $em->getRepository('AppBundle:SocialAccount')
                       ->findForUpdateEvents();

        if ($accounts) {
            foreach ($accounts as $account) {
                $this->getContainer()->get('app.helper.calendar')->updateEventsFromCalendar($account);
            }

            $em->flush();
            $em->clear();
        }

    }
}

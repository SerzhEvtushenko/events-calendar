<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $accounts          = $this->container->get('app.helper.user')->getAccountList();
        $googleProviderUrl = $this->container->get('social.provider.google')->generateCreateAccountUrl();

        return $this->render('@App/default/index.html.twig', [
            'accounts'          => $accounts,
            'googleProviderUrl' => $googleProviderUrl
        ]);
    }


    /**
     * @Route("/social/{type}/create-account/callback" , name="social_create_account_callback")
     */
    public function redirectCreateAccountAction(Request $request, $type)
    {
        $code = $request->query->get('code');
        $this->container->get('app.helper.user')->addSocialAccount($type, $code);

        return $this->redirectToRoute('homepage');
    }

    /**
     * @Route("add-event/{accountId}/", name="add_event")
     */
    public function addEventAction(Request $request, $accountId)
    {
        $message = $request->request->get('message');
        $user    = $this->container->get('app.helper.user')->getCurrentUser();
        $account = $this->container->get('doctrine')->getRepository('AppBundle:SocialAccount')
                                   ->findOneBy(['id' => $accountId, 'user' => $user]);

        if ($account) {
            $this->container->get('app.helper.calendar')->addNewEvents($account, $message);
        }

        return $this->redirectToRoute('homepage');
    }

}

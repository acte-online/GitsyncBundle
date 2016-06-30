<?php

namespace GitsyncBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Request;

//Model : Entity
use GitsyncBundle\Entity\Gitsync;

class GitsyncController extends Controller
{

    /**
     * @Route("/gitsync/config", name="gitsyncconfig")
     */
    public function configAction(Request $request)
    {
        $em         = $this->getDoctrine()->getManager();
        $CGitsync   = $em->getRepository('GitsyncBundle:Gitsync')->findAll();

        if(!empty($CGitsync))
        {

            
            return $this->render('GitsyncBundle:Gitsync:config-view.html.twig', array(
            'CGitsync'  => $CGitsync,
            ));
        }
        else
        {
            
            $form       = Request::createFromGlobals();
        
            if ($form->request->has('submit')) 
            {
                //================================
                // ON RECUPERE LES POSTS DU FORM
                //================================

                $Preponame      = $form->request->get('reponame');
                $Pdirclone      = $form->request->get('dirclone');
                $Pchwuclone     = $form->request->get('chwuclone');
                $Pchwgclone     = $form->request->get('chwgclone');


                $Pdirrepo       = $form->request->get('dirrepo');
                $Pchwurepo      = $form->request->get('chwurepo');
                $Pchwgrepo      = $form->request->get('chwgrepo');

                $dateNow        = new \DateTime('now');


                //====================
                // SET CONFIG
                //====================
                $gitsyncconfig  = new Gitsync;

                //Clone
                $gitsyncconfig->setReponame($Preponame);
                $gitsyncconfig->setDirclone($Pdirclone);
                $gitsyncconfig->setChwuclone($Pchwuclone);
                $gitsyncconfig->setChwgclone($Pchwgclone);

                // Repository
                $gitsyncconfig->setDirrepo($Pdirrepo);
                $gitsyncconfig->setChwurepo($Pchwurepo);
                $gitsyncconfig->setChwgrepo($Pchwgrepo);

                // Date update
                $gitsyncconfig->setDateupdate($dateNow);

                $em->persist($gitsyncconfig);
                $em->flush();


                return $this->redirectToRoute('gitsyncconfig');
            }

            return $this->render('GitsyncBundle:Gitsync:config.html.twig', array(
            'CGitsync'  => $CGitsync,
            ));
        }

        

        return $this->render('GitsyncBundle:Gitsync:config.html.twig', array(
            'CGitsync'  => $CGitsync,
            ));
    }


    /**
     * @Route("/gitsync/config/edit/{id}", name="gitsyncconfigedit")
     */
    public function configeditAction(Request $request, $id)
    {


        $em = $this->getDoctrine()->getManager();
        $gitsyncconfig = $em->getRepository('GitsyncBundle:Gitsync')->find($id);

        if (!$gitsyncconfig) {
            throw $this->createNotFoundException(
                'No Gitsync found for id '.$id
            );
        }

        $form       = Request::createFromGlobals();


        //================================
        // ON RECUPERE LES POSTS DU FORM
        //================================

        $Preponame      = $form->request->get('reponame');
        $Pdirclone      = $form->request->get('dirclone');
        $Pchwuclone     = $form->request->get('chwuclone');
        $Pchwgclone     = $form->request->get('chwgclone');


        $Pdirrepo       = $form->request->get('dirrepo');
        $Pchwurepo      = $form->request->get('chwurepo');
        $Pchwgrepo      = $form->request->get('chwgrepo');

        $dateNow        = new \DateTime('now');


        //====================
        // SET CONFIG
        //====================

        //Clone
        $gitsyncconfig->setReponame($Preponame);
        $gitsyncconfig->setDirclone($Pdirclone);
        $gitsyncconfig->setChwuclone($Pchwuclone);
        $gitsyncconfig->setChwgclone($Pchwgclone);

        // Repository
        $gitsyncconfig->setDirrepo($Pdirrepo);
        $gitsyncconfig->setChwurepo($Pchwurepo);
        $gitsyncconfig->setChwgrepo($Pchwgrepo);

        // Date update
        $gitsyncconfig->setDateupdate($dateNow);

        $em->flush();

        return $this->redirectToRoute('gitsyncconfig');
    }




    /**
     * @Route("/gitsync/pull", name="gitsyncpull")
     */
    public function pullAction()
    {
        $em         = $this->getDoctrine()->getManager();
        $CGitsync   = $em->getRepository('GitsyncBundle:Gitsync')->findall();

        //dump($CGitsync[0]);
        //die();

        // Repository name
        $REPOName   = $CGitsync[0]->getReponame();

        
        // User / Group
        $UClone     = $CGitsync[0]->getChwuclone();
        $GClone     = $CGitsync[0]->getChwgclone();
        // Path repository Clone
        $DIRClone   = $CGitsync[0]->getDirclone();
        //$PATClone   = "$DIRClone/$REPOName";
        $PATClone   = "$DIRClone/";

        // CLONE
        // User / Group
        $URepo     = $CGitsync[0]->getChwuclone();
        $GRepo     = $CGitsync[0]->getChwgclone();
        
        // REPOSITORY
        // Path repository ( git )
        $DIRRepo   = $CGitsync[0]->getDirrepo();
        $PATRepo   = "$DIRRepo/$REPOName";


        //EXEC SHELL
        // chown repo.git ( src )
        //exec("chown -R $URepo:$GRepo".$PATRepo);
        // chown clone ( clone )
        //exec("chown -R $UClone:$GClone".$PATClone);

        exec("cd $DIRClone && git pull 2>&1", $output);

        // chown repo.git ( src )
        //exec("chown -R $URepo:$GRepo".$PATRepo);
        // chown clone ( clone )
        //exec("chown -R $UClone:$GClone".$PATClone);


		$outputs = $output;

        return $this->render('GitsyncBundle:Gitsync:pull.html.twig', array(
        	'outputs'	=> $outputs,
        	));
    }
}

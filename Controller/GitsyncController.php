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

        // Repository name
        $REPOName   = $CGitsync[0]->getReponame();

        // Path repository Clone
        $DIRClone   = $CGitsync[0]->getDirclone();
        $PATClone   = "$DIRClone/";
        
        // REPOSITORY
        // Path repository ( git )
        $DIRRepo   = $CGitsync[0]->getDirrepo();
        $PATRepo   = "$DIRRepo/$REPOName";


        //EXEC SHELL
        exec("cd $DIRClone && git pull 2>&1", $output);
        exec("cd $DIRClone && git status", $gitstatus);

		$outputs = $output;

        return $this->render('GitsyncBundle:Gitsync:pull.html.twig', array(
        	'outputs'      => $outputs,
            'gitstatus'    => $gitstatus,
        	));
    }


    /**
     * @Route("/gitsync/commit/view", name="gitsynccommitview")
     */
    public function commitviewAction()
    {

        $em         = $this->getDoctrine()->getManager();
        $CGitsync   = $em->getRepository('GitsyncBundle:Gitsync')->findall();

        // Path repository Clone
        $DIRClone   = $CGitsync[0]->getDirclone();
        $PATClone   = "$DIRClone/";

        exec("cd $DIRClone && git status", $gitstatus);
        exec("cd $DIRClone && git log --graph", $outgraphs);

        return $this->render('GitsyncBundle:Gitsync:commit-view.html.twig', array(
            'gitstatus'    => $gitstatus,
            'outgraphs'    => $outgraphs,
            ));

    }
}

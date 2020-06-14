<?php
namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use AppBundle\Entity\Contact;

class ContactsController extends Controller {
    
    /**
     * @Route("/", name="home")
     */
    public function indexAction() {
        $repository = $this->getDoctrine()->getRepository(Contact::class);
        $allContacts = $repository->findAll();
        return $this->render('contacts/index.html.twig', ['allContacts' => $allContacts]);
    }
    
    /**
     * @Route("/create", name="create")
     */
    public function createAction(Request $request) { 
        $contact = new Contact();
       
        $form = $this->privateCreateForm($contact, 'Create');
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $contact = $form->getData();
            $contact->setDateCreated(time());
            $this->privateCreateEditEntityManager($contact);
            return $this->redirectToRoute('home');
        }
        
        return $this->render('/contacts/createEdit.html.twig', ['form' => $form->createView()]);
    }
    
    /**
     * @Route("/edit/{contactId}", name="edit")
     */
    public function editAction($contactId, Request $request) {
        $repository = $this->getDoctrine()->getRepository(Contact::class);
        $contact = $repository->find(intval($contactId));
        if(!$contact) {
            return $this->redirectToRoute('home');
        }
        
        $form = $this->privateCreateForm($contact, 'Save');
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $contact = $form->getData();
            $this->privateCreateEditEntityManager($contact);
            return $this->redirectToRoute('home');
        }        
        
        return $this->render('/contacts/createEdit.html.twig', ['form' => $form->createView()]);
    }
    
    
    /**
     * @Route("/delete/{contactId}", name="delete")
     */
    public function deleteAction($contactId, Request $request) {
        $repository = $this->getDoctrine()->getRepository(Contact::class);
        $contact = $repository->find(intval($contactId));
        if(!$contact) {
            return $this->redirectToRoute('home');
        }
        
        $form = $this->createFormBuilder()
                ->add('delete', SubmitType::class, ['label' => 'Delete'])
                ->getForm();
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($contact);
            $entityManager->flush();
            return $this->redirectToRoute('home');
        }           
        
        return $this->render('contacts/delete.html.twig', ['form' => $form->createView(), 'contact' => $contact]);
    }
    
    
    /**
     * @param $contact
     * @param string $labelSubmit
     */
    private function privateCreateForm($contact, string $labelSubmit) {
        $form = $this->createFormBuilder($contact)
                ->add('firstName', TextType::class, ['label' => 'Firstname'])
                ->add('lastName', TextType::class, ['label' => 'Lastname'])
                ->add('number', TextType::class)
                ->add('save', SubmitType::class, ['label' => $labelSubmit])
                ->getForm();
        return $form;
    }
    
    /**
     * @param $contact
     * @return void
     */
    private function privateCreateEditEntityManager($contact): void {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($contact);
        $entityManager->flush();
    }
}

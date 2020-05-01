<?php

namespace App\Controller;

use App\Entity\City;
use App\Entity\Country;
use App\Form\CityType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class TownController extends AbstractController
{
    /**
     * @Route("/town", name="town")
     */
    public function index()
    {
        return $this->render('town/index.html.twig', [
            'controller_name' => 'TownController',
        ]);
    }


    /**
    * @Route("/town/listing", name="town_listing")
    */
    public function townListing()
    {
        $repository = $this->getDoctrine()->getRepository(City::class);
        $town = $repository->findall();
        return $this->render('town/listing.html.twig', array(
            'town' => $town
        ));
    }

    /**
     * @Route("/town/admin/create", name="town_create")
     *
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function createTown(Request $request)
    {
        $town = new City();
        $form = $this->createForm(CityType::class, $town, array());
        $form->handleRequest($request);
        if ($form->isSubmitted() and $form->isValid()) {
            $town->setName($form['name']->getData());
            $town->setCountrycode($form['countrycode']->getData());
            $town->setDistrict($form['district']->getData());
            $town->setPopulation($form['population']->getData());
            $em = $this->getDoctrine()->getManager();
            $em->persist($town);
            $em->flush();
            return $this->redirectToRoute('town_listing');
        }
        return $this->render('town/create.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/town/admin/edit/{id}", name="town_edit")
     *
     * @param int $id
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function editTown($id,Request $request)
    {
        $town = $this->getDoctrine()
        ->getRepository(City::class)
        ->findOneBy(array('id' => $id));
        $form = $this->createForm(CityType::class, $town, array());
        $form->handleRequest($request);
        if ($form->isSubmitted() and $form->isValid()) {
            $town->setName($form['name']->getData());
            $town->setCountrycode($form['countrycode']->getData());
            $town->setDistrict($form['district']->getData());
            $town->setPopulation($form['population']->getData());
            $em = $this->getDoctrine()->getManager();
            $em->persist($town);
            $em->flush();
            return $this->redirectToRoute('town_listing');
        }
        return $this->render('town/create.html.twig', array(
            'town' => $town,
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/town/admin/delete/{id}", name="town_delete")
     *
     * @param int $id
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function deleteTown($id)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($this->getDoctrine()
            ->getRepository(City::class)
            ->findOneBy(array('id' => $id)));
        $em->flush();
        return $this->redirectToRoute('town_listing');
    }
}

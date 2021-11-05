<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\OptionsResolver\OptionsResolver;


use App\Entity\Car;
use App\Repository\CarRepository;
use App\Data\SearchData;

class IndexController extends AbstractController
{
    /**
     * @Route("/", name="app_index")
     */
    public function index(Request $request, CarRepository $repository): Response
    {
        //$car = new Car();

        $data = new SearchData();
        $data->page = $request->get('page', 1);

        $form = $this->createFormBuilder($data)
                    ->setMethod('GET')
                    ->add('q', TextType::class,[
                        'label' => FALSE,
                        'required' => FALSE,
                        'attr' => [
                            'placeholder' => "Search",
                            'class' => "p-2 m-3"
                        ]
                    ])
                    ->add('search', SubmitType::class, [
                        'attr' => [
                            'class' => "btn btn-lg btn-secondary fw-bold m-3",
                        ]
                    ])
                    ->getForm();
        

        $form->handleRequest($request);

        
        $cars = $repository->findSearch($data);
        return $this->render('index/index.html.twig', [
            'cars' => $cars,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/test", name="app_test")
     */

    public function test(Request $request, CarRepository $repository) {

        $data = new SearchData();

        $cars = $repository->findSearch($data);

        return $this->render('index/test.html.twig', [
            'cars' => $cars,
        ]);
    }

    public function configureOptions(OptionsResolver $resolver){

        $resolver->setDefaults([
            'data_class' => SearchData::class,
            'method' => 'GET',
            'csrf_protection' => false
        ]);
    }
}

<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

use App\Entity\Car;

class CarFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);

        for($i = 0; $i < 10; $i++){
            $car = new Car();
            if($i%2 == 0){
                $car->setBrand("Peugeot")
                    ->setModel("20$i")
                    ->setYear("201$i")
                    ->setMileage(rand(10000, 250000))
                    ->setPrice(rand(10000, 25000))
                    ->setLocation("Paris");
            } else {
                $car->setBrand("Renault")
                    ->setModel("R$i")
                    ->setYear("200$i")
                    ->setMileage(rand(10000, 250000))
                    ->setPrice(rand(5000, 15000))
                    ->setLocation("Melun");

            }
            
            $manager->persist($car);
        }

        $manager->flush();
    }
}

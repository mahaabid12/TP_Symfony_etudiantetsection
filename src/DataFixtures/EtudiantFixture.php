<?php

namespace App\DataFixtures;

use App\Entity\Etudiant;
use App\Entity\Section;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\DBAL\Driver\IBMDB2\Exception\Factory as ExceptionFactory;
use Doctrine\Persistence\ObjectManager;
use Faker;

class EtudiantFixture extends Fixture  
{

  
    
    public function load(ObjectManager $manager): void{
     $fakor= Faker\Factory ::create(); 

     

        for($i=0 ; $i<10 ; $i++){
         $etudiant=new Etudiant(); 
         $sect=new Section(); 
         $etudiant->setNom($fakor->firstName); 
         $etudiant->setPrenom($fakor->lastName); 
         $sect->setDesignation('section'.$i); 
         $etudiant->setSection($sect); 
         $manager->persist($sect); 
         $manager->persist($etudiant);
        }

        for($i=0 ; $i<10 ; $i++){
            $etudiant=new Etudiant(); 
   
            $etudiant->setNom($fakor->firstName); 
            $etudiant->setPrenom($fakor->lastName); 

            $manager->persist($etudiant); 

        }
        

        $manager->flush();
    }
}

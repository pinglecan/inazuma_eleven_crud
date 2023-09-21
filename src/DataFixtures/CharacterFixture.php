<?php

namespace App\DataFixtures;

use App\Entity\Character;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class CharacterFixture extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $character = new Character();
        $character->setTitle('Byron Love');
        $character->setGender('Male');
        $character->setPosision('MF');
        $character->setImage('https://static.wikia.nocookie.net/inazuma-eleven/images/2/2c/Afuro_Terumi_%28Orion%29.png/revision/latest?cb=20190510150434');
        
        $character->addTeam($this->getReference('team_1'));
        $character->addTeam($this->getReference('team_2'));
        
        $manager->persist($character);

        $character2 = new Character();
        $character2->setTitle('Mark Evans');
        $character2->setGender('Male');
        $character2->setPosision('GK');
        $character2->setImage('https://static.wikia.nocookie.net/inazuma-eleven/images/d/dc/Endou_Mamoru1.png/revision/latest?cb=20130111212724&path-prefix=nl');
        
        $character2->addTeam($this->getReference('team_2'));
        $character2->addTeam($this->getReference('team_3'));
        
        $manager->persist($character2);

        $manager->flush();

    }

    public function getDependencies()
    {
        return [
            TeamFixtures::class,
        ];
    }
}

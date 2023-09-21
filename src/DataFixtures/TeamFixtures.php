<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Team;

class TeamFixtures extends Fixture
{
    public const ZEUS_JUNIOR = 'zeus-junior';
    public const RAINMON_ELEVEN = 'rainmon-eleven';
    public const INAZUMA_JAPAN = 'inazuma-japan';
    public const FIRE_DRAGON = 'fire-dragon';

    public function load(ObjectManager $manager): void
    {
        $team = new Team();
        $team->setName('Zeus Junior');
        $team->setImage('https://static.wikia.nocookie.net/inazuma-eleven/images/a/a8/Zeus_%28Ares%29_emblem_%28SD%29.png/revision/latest?cb=20230802094850');
        $manager->persist($team);

        $team2 = new Team();
        $team2->setName('Rainmon Eleven');
        $team2->setImage('https://files.cults3d.com/uploaders/22012644/illustration-file/5ac307a2-a210-4fd4-ab1d-c43d7d7ac961/raimon.jpg');
        $manager->persist($team2);

        $team3 = new Team();
        $team3->setName('Inazuma Japan');
        $team3->setImage('https://ih1.redbubble.net/image.2348264157.7689/st,small,507x507-pad,600x600,f8f8f8.jpg');
        $manager->persist($team3);

        $team4 = new Team();
        $team4->setName('Fire Dragon');
        $team4->setImage('https://static.wikia.nocookie.net/inazuma-eleven/images/0/09/Fire_Dragon_emblem.png/revision/latest/scale-to-width-down/256?cb=20230726183618');
        $manager->persist($team4);


        $manager->flush();

        $this->addReference('team_1', $team);
        $this->addReference('team_2', $team2);
        $this->addReference('team_3', $team3);
        $this->addReference('team_4', $team4);
    }
}

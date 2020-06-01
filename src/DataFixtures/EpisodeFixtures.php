<?php


namespace App\DataFixtures;

use App\Entity\Episode;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Faker;


class EpisodeFixtures extends Fixture implements DependentFixtureInterface
{
    /**
     * @return array
     */
    public function getDependencies()
    {
        return  [SeasonFixtures::class];
    }

    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('en_US');

            $episode = new Episode();
/**
            $episode->setSeason($this->getReference('season_1' ));
            $episode->setTitle($faker->words(rand(1, 6), true));
            $episode->setNumber(1);
            $episode->setSynopsis($faker->text(200));
            $manager->persist($episode);
            $this->addReference('episode_1', $episode);
 * **/
        $episodeRef = 1;
        for ($i=0; $i<12; $i++) {
            for ($j=1; $j<rand(10, 20); $j++) {
                $episode = new Episode();
                $episode->setSeason($this->getReference('season_' . $i));
                $episode->setTitle($faker->words(rand(1, 3), true));
                $episode->setNumber($j);
                $episode->setSynopsis($faker->text(200));
                $manager->persist($episode);
                $this->addReference('episode_' . $episodeRef, $episode);
                $episodeRef++;
            }
        }
            $manager->flush();
    }

}

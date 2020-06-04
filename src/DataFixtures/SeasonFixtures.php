<?php


namespace App\DataFixtures;

use App\Entity\Season;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker;

class SeasonFixtures extends Fixture implements DependentFixtureInterface
{
    /**
     * @return array
     */
    public function getDependencies()
    {
        return [ProgramFixtures::class];
    }

    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {;
        $faker = Faker\Factory::create('en_US');
        for ($i=0; $i<6 ; $i++) {
            $season = new Season();
            $program = $this->getReference('program_' . $i);
            $season->setProgram($program);
            $season->setNumber(1);
            $season->setYear($program->getYear());
            $season->setDescription($faker->sentence);
            $manager->persist($season);
            $this->addReference('season_' . $i, $season);
        }
        $seasonRef = 6;
        for ($j=0; $j<6 ; $j++) {
            $season = new Season();
            $program = $this->getReference('program_' . $j);
            $season->setProgram($program);
            $season->setNumber(2);
            $season->setYear($program->getYear() + 1);
            $season->setDescription($faker->sentence);
            $manager->persist($season);
            $this->addReference('season_' . $seasonRef, $season);
            $seasonRef++;
        }

        $manager->flush();
    }
}

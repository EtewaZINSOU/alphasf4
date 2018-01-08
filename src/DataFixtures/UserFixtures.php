<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture implements DependentFixtureInterface
{
    const MAX_NB = 5;


    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        // use the factory to create a Faker\Generator instance
        $faker = Factory::create();

        for ($i = 1; $i <= self::MAX_NB; $i++) {
            $user = new User();
            $user
                ->setFullName($faker->firstName().' '.$faker->lastName)
                ->setUsername($i === 5 ? 'admin' : $faker->userName)
                ->setPassword($i === 5 ? $this->passwordEncoder->encodePassword($user,'admin') : $this->passwordEncoder->encodePassword($user,'test'))
                ->setEmail($faker->email)
                ->setRoles($i === 5 ? [User::ROLE_ADMIN] : [User::ROLE_USER])
                ;
            $this->setReference('user'.$i, $user);
            $manager->persist($user);
        }

        $manager->flush();

    }



    /**
     * This method must return an array of fixtures classes
     * on which the implementing class depends on
     *
     * @return array
     */
    function getDependencies()
    {
        // TODO: Implement getDependencies() method.
    }
}
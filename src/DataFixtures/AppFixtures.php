<?php

namespace App\DataFixtures;

use Faker;
use App\Entity\User;
use App\Entity\Articles;
use App\Entity\Categorys;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{

    private $passwordEncoder;

    private $user;

    private $categorys;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);
        $faker = Faker\Factory::create();
        $user = new User();
        $articles = new Articles();

        $user
            ->setEmail('email@email.fr')
            ->setPassword($this->passwordEncoder->encodePassword($user, 'password'))
            ->setRoles(['ROLE_ADMIN'])
            ->setPseudo("Big Brother");

        for ($i=0; $i < 10; $i++) { 
            $users = new User();
            $users
            ->setEmail($faker->safeEmail())
            ->setPassword($this->passwordEncoder->encodePassword($user, 'password'))
            ->setRoles(['ROLE_USER'])
            ->setPseudo($faker->name());

            $manager->persist($users);
            $manager->flush();
        }

        $categorys = ['sport','life-style','actu'];
        for ($i=0; $i < count($categorys); $i++) { 
            $category = new Categorys();

            $category->setName($categorys[$i]);

            $manager->persist($category);
            $manager->flush();
        }


        $manager->persist($user);
        $manager->flush();

    }
}

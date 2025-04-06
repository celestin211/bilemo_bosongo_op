<?php

namespace App\DataFixtures;


use App\Entity\Person;
use App\Entity\Product;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager; // Updated to Doctrine\Persistence
use Faker\Factory;


class LoadFixtures extends Fixture implements FixtureGroupInterface
{


    public function __construct()
    {

    }

    public static function getGroups(): array
    {
        return ['test'];
    }

    public function load(ObjectManager $manager):void
    {
        $faker = Factory::create();

        // Create Users
        $operator = [1 => 'sfr', 2 => 'orange'];
        $users = []; // Initialize the $users array

        for ($i = 1; $i <= 2; ++$i) {
            $user = new User();
            $user->setUsername($operator[$i])
                ->setPassword($user)
            ;
            $manager->persist($user);
            $users[] = $user; // Add the created user to the $users array
        }

        // Create People
        for ($i = 1; $i <= 10; ++$i) {
            $person = new Person();
            $person->setEmail($faker->email())
                ->setFirstname($faker->firstName())
                ->setLastname($faker->lastName())
                ->setUserClient($faker->randomElement($users)) // Assign a random user from $users array
            ;
            $manager->persist($person);
        }

        // Create Products
        $brands = ['Apple', 'Samsung', 'Huawei', 'Sony', 'Google'];
        $colors = ['Azure', 'Black', 'Cyan', 'Gold', 'Lime', 'Orchid', 'Ruby', 'Silver', 'White'];
        $storageGB = [8, 16, 32, 64];
        $memoryGB = [4, 6, 8, 12, 16];

        for ($i = 1; $i <= 50; ++$i) {
            $product = new Product();
            $product->setBrand($brand = $faker->randomElement($brands))
                ->setModel($brand.$faker->numberBetween(0, 10))
                ->setReleaseYear($faker->numberBetween(2015, 2019))
                ->setColor($faker->randomElement($colors))
                ->setScreenSize($faker->randomFloat(2, 4, 8))
                ->setStorageGB($faker->randomElement($storageGB))
                ->setMemoryGB($faker->randomElement($memoryGB))
                ->setMegapixels($faker->numberBetween(6, 20))
                ->setPrice($faker->numberBetween(500, 1200))
            ;
            $manager->persist($product);
        }

        // Flush all data to the database
        $manager->flush();
    }
}

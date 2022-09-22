<?php

namespace App\DataFixtures;

use App\Entity\Project;
use App\Entity\Space;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Nelmio\Alice\Loader\NativeLoader;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $loader = new NativeLoader();
        $data = $loader->loadData([
            Space::class => [
                'space{1..10}' => [
                    'uuid' => '<uuid()>',
                    'alias' => '<numerify(space-###)>',
                    'name' => '<bothify(?????-#####)>'
                ]
            ],
            Project::class => [
                'project{1..50}' => [
                    'space' => '@space*',
                    'uuid' => '<uuid()>',
                    'alias' => '<numerify(space-###)>',
                    'name' => '<colorName()>',
                    'description' => '<paragraph()>',
                    'status' => '<randomElement([active,inactive])>'
                ]
            ],
            User::class => [
                'user{1..200}' => [
                    'space' => '@space*',
                    'username' => '<username()>',
                    'roles' => ['<numerify(###)>'],
                    'password' => 'PASSWORD',
                    'name' => '<firstName()> <lastName()>',
                    'email' => '<email()>',
                    'status' => '<randomElement([active,inactive])>'    
                ]
            ]
        ]);
        foreach ($data->getObjects() as $item) {
            $manager->persist($item);
        }
        $manager->flush();
    }
}

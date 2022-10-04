<?php

namespace App\DataFixtures;

use App\Entity\Epic;
use App\Entity\Project;
use App\Entity\Space;
use App\Entity\Task;
use App\Entity\User;
use App\Entity\UserProject;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;
use Nelmio\Alice\Loader\NativeLoader;

class TestFixtures extends Fixture implements FixtureGroupInterface
{
    public static function getGroups(): array
    {
        return ['test'];
    }

    public function load(ObjectManager $manager): void
    {
        $loader = new NativeLoader();
        $data = $loader->loadData([
            Space::class => [
                'space{1..10}' => [
                    'uuid' => '<uuid()>',
                    'alias (unique)' => '<numerify(space-###)>',
                    'name' => '<bothify(?????-#####)>'
                ]
            ],
            Project::class => [
                'project{1..50}' => [
                    'space' => '@space*',
                    'uuid' => '<uuid()>',
                    'alias (unique)' => '<numerify(space-###)>',
                    'name' => '<colorName()>',
                    'description' => '<paragraph()>',
                    'status' => '<randomElement([active,inactive])>'
                ]
            ],
            User::class => [
                'user{1..200}' => [
                    'space' => '@space*',
                    'username (unique)' => '<username()>',
                    'roles' => ['ROLE_USER'],
                    'password' => 'PASSWORD',
                    'name' => '<firstName()> <lastName()>',
                    'email' => '<email()>',
                    'status' => '<randomElement([active,inactive])>'    
                ]
            ],
            UserProject::class => [
                'up{1..400}' => [
                    'user' => '@user*',
                    'project' => '@project*',
                    'role' => 'ROLE_USER'
                ]
            ],

            Epic::class => [
                'epic{1..200}' => [
                    'project' => '@project*',
                    'uuid' => '<uuid()>',
                    'alias (unique)' => '<bothify(???-####)>',
                    'title' => '<sentence()>',
                    'description' => '<text()>',
                    'status' => '<randomElement([todo, standby, inprogress, done])>'
                ]
            ],
            Task::class => [
                'task{1..500}' => [
                    'epic' => '@epic*',
                    'uuid' => '<uuid()>',
                    'type' => 'task',
                    'creationDate' => '<dateTime()>',
                    'alias (unique)' => '<bothify(???-####)>',
                    'title' => '<sentence()>',
                    'status' => '<randomElement([todo, inprogress, done])>',
                    'description' => '<text()>',
                    'creationUser' => '@user*',
                ]
            ],
        ]);
        foreach ($data->getObjects() as $item) {
            $manager->persist($item);
        }
        $manager->flush();
    }
}

<?php

namespace App\Infrastructure\Symfony\DataFixtures;

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

class Test1Fixtures extends Fixture implements FixtureGroupInterface
{
    public static function getGroups(): array
    {
        return ['test1'];
    }

    public function load(ObjectManager $manager): void
    {
        $loader = new NativeLoader();
        $data = $loader->loadData([
            Space::class => [
                'space1' => [
                    'uuid' => 'space1',
                    'alias (unique)' => 'space1',
                    'name' => 'Space 1'
                ]
            ],
            Project::class => [
                'project1' => [
                    'space' => '@space1',
                    'uuid' => 'project1',
                    'alias (unique)' => 'project1',
                    'name' => '<colorName()>',
                    'description' => '<paragraph()>',
                    'status' => '<randomElement([active,inactive])>'
                ],
                'project2' => [
                    'space' => '@space1',
                    'uuid' => 'project2',
                    'alias (unique)' => 'project3',
                    'name' => '<colorName()>',
                    'description' => '<paragraph()>',
                    'status' => '<randomElement([active,inactive])>'
                ]
            ],
            User::class => [
                'user1' => [
                    'space' => '@space*',
                    'username (unique)' => 'username1',
                    'roles' => ['ROLE_USER'],
                    'password' => 'PASSWORD',
                    'name' => '<firstName()> <lastName()>',
                    'email' => '<email()>',
                    'status' => '<randomElement([active,inactive])>'    
                ],
                'user2' => [
                    'space' => '@space*',
                    'username (unique)' => 'username2',
                    'roles' => ['ROLE_USER'],
                    'password' => 'PASSWORD',
                    'name' => '<firstName()> <lastName()>',
                    'email' => '<email()>',
                    'status' => '<randomElement([active,inactive])>'    
                ]
            ],
            UserProject::class => [
                'up1' => [
                    'user' => '@user1',
                    'project' => '@project1',
                    'role' => 'ROLE_USER'
                ],
                'up2' => [
                    'user' => '@user2',
                    'project' => '@project2',
                    'role' => 'ROLE_USER'
                ]
            ],

            Epic::class => [
                'epic1' => [
                    'project' => '@project1',
                    'uuid' => 'epic1',
                    'alias (unique)' => '<bothify(???-####)>',
                    'title' => '<sentence()>',
                    'description' => '<text()>',
                    'status' => '<randomElement([todo, standby, inprogress, done])>'
                ],
                'epic2' => [
                    'project' => '@project1',
                    'uuid' => 'epic2',
                    'alias (unique)' => '<bothify(???-####)>',
                    'title' => '<sentence()>',
                    'description' => '<text()>',
                    'status' => '<randomElement([todo, standby, inprogress, done])>'
                ],
                'epic3' => [
                    'project' => '@project2',
                    'uuid' => 'epic3',
                    'alias (unique)' => '<bothify(???-####)>',
                    'title' => '<sentence()>',
                    'description' => '<text()>',
                    'status' => '<randomElement([todo, standby, inprogress, done])>'
                ],
                'epic4' => [
                    'project' => '@project2',
                    'uuid' => 'epic4',
                    'alias (unique)' => '<bothify(???-####)>',
                    'title' => '<sentence()>',
                    'description' => '<text()>',
                    'status' => '<randomElement([todo, standby, inprogress, done])>'
                ]
            ],
            Task::class => [
                'task1' => [
                    'epic' => '@epic1',
                    'uuid' => 'task1',
                    'type' => 'task',
                    'creationDate' => '<dateTime()>',
                    'alias (unique)' => '<bothify(???-####)>',
                    'title' => 'Lorem ipsum dolor sit amet',
                    'status' => '<randomElement([todo, inprogress, done])>',
                    'description' => '<text()>',
                    'creationUser' => '@user*',
                ],
                'task2' => [
                    'epic' => '@epic2',
                    'uuid' => 'task2',
                    'type' => 'task',
                    'creationDate' => '<dateTime()>',
                    'alias (unique)' => '<bothify(???-####)>',
                    'title' => 'Consectetur adipiscing elit',
                    'status' => '<randomElement([todo, inprogress, done])>',
                    'description' => '<text()>',
                    'creationUser' => '@user*',
                ],
                'task3' => [
                    'epic' => '@epic3',
                    'uuid' => 'task3',
                    'type' => 'task',
                    'creationDate' => '<dateTime()>',
                    'alias (unique)' => '<bothify(???-####)>',
                    'title' => 'Donec cursus eros vitae cursus vulputate',
                    'status' => '<randomElement([todo, inprogress, done])>',
                    'description' => '<text()>',
                    'creationUser' => '@user*',
                ],
                'task4' => [
                    'epic' => '@epic4',
                    'uuid' => 'task4',
                    'type' => 'task',
                    'creationDate' => '<dateTime()>',
                    'alias (unique)' => '<bothify(???-####)>',
                    'title' => 'Mauris et lobortis massa',
                    'status' => '<randomElement([todo, inprogress, done])>',
                    'description' => '<text()>',
                    'creationUser' => '@user*',
                ],
                'task5' => [
                    'epic' => '@epic1',
                    'uuid' => 'task5',
                    'type' => 'task',
                    'creationDate' => '<dateTime()>',
                    'alias (unique)' => '<bothify(???-####)>',
                    'title' => 'Neque porro quisquam est qui dolorem ipsum quia dolor sit amet',
                    'status' => '<randomElement([todo, inprogress, done])>',
                    'description' => '<text()>',
                    'creationUser' => '@user*',
                ],
                'task6' => [
                    'epic' => '@epic2',
                    'uuid' => 'task6',
                    'type' => 'task',
                    'creationDate' => '<dateTime()>',
                    'alias (unique)' => '<bothify(???-####)>',
                    'title' => 'Cras mollis, nulla vel porta rhoncus',
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

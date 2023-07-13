<?php

namespace App\DataFixtures;

use App\Entity\Task;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $user = new User();
        $user->setName('user1');
        $user->setPassword('$2y$13$172E8pwQiHjzHeCiwXiBrO.k2xtwJ8oIJR3SGvPTUHXmNrTe5mo4y');
        $manager->persist($user);

        $user2 = new User();
        $user2->setName('user2');
        $user2->setPassword('$2y$13$172E8pwQiHjzHeCiwXiBrO.k2xtwJ8oIJR3SGvPTUHXmNrTe5mo4y');
        $manager->persist($user2);

        $this->addReference('user', $user);
        $this->addReference('user2', $user2);

        $task = new Task();
        $task->setText("task1 bo nie mam pomysłu");
        $task->setDay('jutro');
        $task->setReminder(true);
        $task->setUser($this->getReference('user'));
        $manager->persist($task);

        $task2 = new Task();
        $task2->setText("task2 bo nie mam pomysłu");
        $task2->setDay(null);
        $task2->setReminder(false);
        $task2->setUser($this->getReference('user'));
        $manager->persist($task2);

        $task3 = new Task();
        $task3->setText("task3 bo nie mam pomysłu");
        $task3->setDay('kiedyś');
        $task3->setReminder(true);
        $task3->setUser($this->getReference('user2'));
        $manager->persist($task3);

        $task4 = new Task();
        $task4->setText("task4 bo nie mam pomysłu");
        // $task4->setDay(null);
        $task4->setReminder(false);
        $task4->setUser($this->getReference('user2'));
        $manager->persist($task4);

        $manager->flush();
    }
}

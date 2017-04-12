<?php
/**
 * Created by PhpStorm.
 * User: micka
 * Date: 11/04/2017
 * Time: 11:53
 */

namespace Blog\UserBundle\DataFixtures\ORM;


use Blog\UserBundle\Entity\User;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadUserData implements FixtureInterface
{

    /**
     * @param ObjectManager $manager
     * @return mixed
     */
    public function load(ObjectManager $manager)
    {
        $userAdmin = new User();
        $userAdmin->setUsername("admin");
        $userAdmin->setPassword('root');
        $userAdmin->setRoles(['ROLE_ADMIN']);
        $manager->persist($userAdmin);

        $userUser = new User();
        $userUser->setUsername("user");
        $userUser->setPassword('toto');
        $userUser->setRoles(['ROLE_USER']);
        $manager->persist($userUser);

        $manager->flush();

    }
}
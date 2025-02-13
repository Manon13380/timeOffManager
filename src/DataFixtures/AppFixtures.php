<?php

namespace App\DataFixtures;

use App\Entity\Enum\StatusEnum;
use App\Entity\User;
use App\Entity\LeaveRequest;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\PasswordHasherFactoryInterface;

class AppFixtures extends Fixture
{
    public function __construct(
        private PasswordHasherFactoryInterface $passwordHasherFactory,
    ) {
    }

    public function load(ObjectManager $manager): void
    {
        $admin1 = new User();
        $admin1->setEmail('admin1@admin.fr');
        $admin1->setRoles(['ROLE_ADMIN']);
        $admin1->setFirstName('John');
        $admin1->setLastName('Doe');
        $admin1->setPassword($this->passwordHasherFactory->getPasswordHasher(User::class)->hash('MotDePasse123'));
        $manager->persist($admin1);

        $admin2 = new User();
        $admin2->setEmail('admin2@admin.fr');
        $admin2->setRoles(['ROLE_ADMIN']);
        $admin2->setFirstName('Jane');
        $admin2->setLastName('Smith');
        $admin2->setPassword($this->passwordHasherFactory->getPasswordHasher(User::class)->hash('MotDePasse123'));
        $manager->persist($admin2);

        $user1 = new User();
        $user1->setEmail('user1@user.fr');
        $user1->setFirstName('Alice');
        $user1->setLastName('Johnson');
        $user1->setPassword($this->passwordHasherFactory->getPasswordHasher(User::class)->hash('MotDePasse123'));
        $manager->persist($user1);

        $user2 = new User();
        $user2->setEmail('user2@user.fr');
        $user2->setFirstName('Robert');
        $user2->setLastName('Brown');
        $user2->setPassword($this->passwordHasherFactory->getPasswordHasher(User::class)->hash('MotDePasse123'));
        $manager->persist($user2);

        $request1 = new LeaveRequest();
        $request1->setUserName(($user1));
        $request1->setStartDate(new \DateTime('2025-02-15 08:00:00'));
        $request1->setEndDate(new \DateTime('2025-02-20 18:00:00'));
        $request1->setStatus(StatusEnum::Draft);
        $request1->setReason('Vacance1');
        $manager->persist($request1);

        $request2 = new LeaveRequest();
        $request2->setUserName(($user2));
        $request2->setStartDate(new \DateTime('2025-02-25 08:00:00'));
        $request2->setEndDate(new \DateTime('2025-03-03 18:00:00'));
        $request2->setStatus(StatusEnum::Submitted);
        $request2->setReason('Vacance2');
        $manager->persist($request2);

        $request3 = new LeaveRequest();
        $request3->setUserName(($user2));
        $request3->setStartDate(new \DateTime('2025-04-15 08:00:00'));
        $request3->setEndDate(new \DateTime('2025-05-02 18:00:00'));
        $request3->setStatus(StatusEnum::Approved);
        $request3->setReason('Vacance3');
        $manager->persist($request3);

        $manager->flush();
    }
}

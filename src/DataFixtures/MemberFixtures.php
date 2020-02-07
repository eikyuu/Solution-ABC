<?php

namespace App\DataFixtures;

use App\Entity\Member;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class MemberFixtures extends Fixture
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }
    public function load(ObjectManager $manager)
    {
        $faker  =  Faker\Factory::create('fr_FR');
        for ($i = 1; $i <= 10; $i++) {
            $ramdomImage = rand(1, 99);
            $lien = "https://randomuser.me/api/portraits/men/" . $ramdomImage . ".jpg";
            $member = new Member();
            $member->setName($faker->name);
            $member->setCompany($faker->company);
            $member->setPhonenumber($faker->serviceNumber);
            $member->setWorkingLocation($faker->streetAddress);
            $member->setPostCode($faker->postcode);
            $member->setCity($faker->city);
            $member->setProfileImage($lien);
            $member->setRegisterEmail($faker->email);
            $member->setRoles(['ROLE_MEMBER']);
            $member->setPassword($this->passwordEncoder->encodePassword(
                $member,
                'password'
            ));
            $manager->persist($member);
        };
        
        $ramdomImage = rand(1, 99);
        $lien = "https://randomuser.me/api/portraits/men/" . $ramdomImage . ".jpg";
        $member = new Member();
        $member->setName($faker->name);
        $member->setCompany($faker->company);
        $member->setPhonenumber($faker->serviceNumber);
        $member->setWorkingLocation($faker->streetAddress);
        $member->setPostCode($faker->postcode);
        $member->setCity($faker->city);
        $member->setProfileImage($lien);
        $member->setRegisterEmail('admin@admin.com');
        $member->setRoles(['ROLE_ADMIN']);
        $member->setPassword($this->passwordEncoder->encodePassword(
            $member,
            'password'
        ));
        $manager->persist($member);

        $manager->flush();
    }
}

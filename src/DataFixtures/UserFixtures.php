<?php

namespace App\DataFixtures;

use App\Entity\ApiToken;
use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends BaseFixture
{
    /**
     * @var UserPasswordEncoderInterface
     */
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    protected function loadData(ObjectManager $manager)
    {
        $this->createMany(10, 'main_users', function($i) use ($manager) {
            $user = new User();
            $user
                ->setEmail(sprintf('spacebar%d@example.com', $i))
                ->setFirstName($this->faker->firstName)
                ->setPassword($this->passwordEncoder->encodePassword(
                    $user,
                    'engage'
                ))
                ->agreeTerms()
            ;

            if($this->faker->boolean) {
                $user->setTwitterUsername($this->faker->userName);
            }

            $apiToken1 = new ApiToken($user);
            $apiToken2 = new ApiToken($user);
            $manager->persist($apiToken1);
            $manager->persist($apiToken2);
            
            return $user;
        });

        $this->createMany(3, 'admin_users', function ($i) {
            $user = new User();
            $user
                ->setEmail(sprintf('admin%d@thespacebar.com', $i))
                ->setFirstName($this->faker->firstName)
                ->setRoles(['ROLE_ADMIN'])
                ->agreeTerms()
                ->setPassword($this->passwordEncoder->encodePassword(
                    $user,
                    'engage'
                ));

            return $user;
        });

        $manager->flush();
    }
}

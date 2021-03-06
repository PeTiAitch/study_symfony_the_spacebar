<?php

namespace App\DataFixtures;

use App\Entity\Article;
use App\Entity\Comment;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class CommentFixture extends BaseFixture implements DependentFixtureInterface
{
    protected function loadData(ObjectManager $manager)
    {
        $this->createManyOld(Comment::class, 100, function(Comment $comment, int $count) {
            $comment->setContent(
                $this->faker->boolean ? $this->faker->paragraph : $this->faker->sentences(2, true)
            )
            ->setAuthorName($this->faker->name)
            ->setCreatedAt($this->faker->dateTimeBetween('-1 months', '-1 seconds'))
            ->setArticle($this->getRandomReference(Article::class))
            ->setIsDeleted($this->faker->boolean(20))
            ;
        });

        $manager->flush();
    }

    public function getDependencies()
    {
        return [ArticleFixtures::class];
    }
}

<?php

namespace App\DataFixtures;

use App\Entity\BlogPost;
use Doctrine\Bundle\FixturesBundle\Fixture;
//use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $blogPost = new BlogPost();
        $blogPost->setTitle('Symfony Developer');
        $blogPost->setPublished(new\DateTime('2020-6-25 12:00:00'));
        $blogPost->setContent('Do you think that web design and web development are easier?');
        $blogPost->setAuthor('Samreaksa Ros');
        $blogPost->setSlug('symfony-dev');
        $manager->persist($blogPost);

        $blogPost = new BlogPost();
        $blogPost->setTitle('Laravel Developer');
        $blogPost->setPublished(new\DateTime('2020-6-25 12:00:00'));
        $blogPost->setContent("BI Take Complex Issues You Face And Turn It Into A Solution That's Easier.");
        $blogPost->setAuthor('Samreaksa Ros');
        $blogPost->setSlug('laravel-dev');
        $manager->persist($blogPost);

        $manager->flush();
    }
}



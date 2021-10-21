<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CategoryFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);

        $this->loadMainCategories($manager);
        $this->loadElectronics($manager);
        $this->loadComputers($manager);
        $this->loadLaptops($manager);
        $this->loadBooks($manager);
        $this->loadMovies($manager);
        $this->loadRomance($manager);


    }

    private function loadMainCategories(ObjectManager $manager): void
    {
        foreach ($this->getMainCategoriesData() as [$name]) {
            $category = new Category();
            $category->setName($name);
            $manager->persist($category);
        }
        
        $manager->flush();

    }

    private function loadSubcategories(ObjectManager $manager, $parentCategoryName)
    {
        
        $parent = $manager->getRepository(Category::class)->findOneBy(['name' => $parentCategoryName]);
        $methodName = 'get' . $parentCategoryName . 'Data';

        foreach ($this->$methodName() as [$name]) {
            $category = new Category();
            $category->setName($name);
            $category->setParent($parent);
            $manager->persist($category);
        }
        
        $manager->flush();
    }

    private function loadElectronics(ObjectManager $manager)
    {
        $this->loadSubcategories($manager, 'Electronics');
    }

    private function loadComputers(ObjectManager $manager)
    {
        $this->loadSubcategories($manager, 'Computers');
    }

    private function loadLaptops(ObjectManager $manager)
    {
        $this->loadSubcategories($manager,'Laptops');
    }
    
    private function loadBooks(ObjectManager $manager)
    {
        $this->loadSubcategories($manager,'Books');
    }
    
    private function loadMovies(ObjectManager $manager)
    {
        $this->loadSubcategories($manager,'Movies');
    }
    
    private function loadRomance(ObjectManager $manager)
    {
        $this->loadSubcategories($manager,'Romance');
    }


    private function getMainCategoriesData()
    {
        return [
            ['Electronics', 1], 
            ['Toys', 2], 
            ['Books', 3], 
            ['Movies', 4]
        ];
    }

    private function getElectronicsData()
    { 
        return [
            ['Cameras', 5], 
            ['Computers', 6], 
            ['Cell Phones', 7]  
        ];
    }

    private function getComputersData()
    { 
        return [
            ['Laptops', 8], 
            ['Desktops', 9]
        ];
    }

    private function getLaptopsData()
    {
        return [

            ['Apple',10],
            ['Asus',11], 
            ['Dell',12], 
            ['Lenovo',13], 
            ['HP',14]

        ];
    }


    private function getBooksData()
    {
        return [
            ['Children\'s Books',15],
            ['Kindle eBooks',16], 
        ];
    }


    private function getMoviesData()
    {
        return [
            ['Family',17],
            ['Romance',18], 
        ];
    }


    private function getRomanceData()
    {
        return [
            ['Romantic Comedy',19],
            ['Romantic Drama',20], 
        ];
    }

}

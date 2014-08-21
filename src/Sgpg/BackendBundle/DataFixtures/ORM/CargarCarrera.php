<?php
namespace Sgpg\BackendBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Sgpg\CarreraBundle\Entity\Carrera;

class CargarCarrera extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
{
    public function getOrder()
    {
        return 20;
    }

    private $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $carrera1 = new Carrera();
        $carrera1->setNombre("Sistemas");
        $carrera1->setDescripcion("Carrera Sistemas");
        $manager->persist($carrera1);
        $manager->flush();
        $carrera2 = new Carrera();
        $carrera2->setNombre("Informatica");
        $carrera2->setDescripcion("Carrera Informatica");
        $manager->persist($carrera2);
        $manager->flush();
    }
}
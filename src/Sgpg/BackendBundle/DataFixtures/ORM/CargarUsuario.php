<?php
namespace Sgpg\BackendBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Sgpg\BackendBundle\Entity\Usuario;

class CargarUsuario extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
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
        $userAdmin = new Usuario();
        $userAdmin->setNombre('Super');
        $userAdmin->setApPaterno('Admin');
        $userAdmin->setApMaterno('Admin');
        $userAdmin->setUsername('admin');
        $userAdmin->setSalt(md5(time()));
        $encoder = $this->container->get('security.encoder_factory')->getEncoder($userAdmin);
        $passwordCodificado = $encoder->encodePassword(
                    $userAdmin->getUsername(),
                    $userAdmin->getSalt()
                );
        $userAdmin->setPassword($passwordCodificado);
        $userAdmin->setTipo("SUPER");
        $manager->persist($userAdmin);
        $manager->flush();
    }
}
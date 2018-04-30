<?php

use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Config\Loader\LoaderInterface;

class AppKernel extends Kernel
{
    public function __construct($environment, $debug) {
        date_default_timezone_set('Europe/Berlin');
        parent::__construct($environment, $debug);
    }
    public function registerBundles()
    {
        $bundles = [
            new Symfony\Bundle\FrameworkBundle\FrameworkBundle(),
            new Symfony\Bundle\SecurityBundle\SecurityBundle(),
            new Symfony\Bundle\TwigBundle\TwigBundle(),
            new Symfony\Bundle\MonologBundle\MonologBundle(),
            new Symfony\Bundle\SwiftmailerBundle\SwiftmailerBundle(),
            new Doctrine\Bundle\DoctrineBundle\DoctrineBundle(),
            new Sensio\Bundle\FrameworkExtraBundle\SensioFrameworkExtraBundle(),
            new AppBundle\AppBundle(),
            new BoutiqueBundle\BoutiqueBundle(),
            new UserBundle\UserBundle(),
            new FOS\UserBundle\FOSUserBundle(),
            new Nomaya\SocialBundle\NomayaSocialBundle(),
            new AncaRebeca\FullCalendarBundle\FullCalendarBundle(),
            new Sante\SpecialisteBundle\SanteSpecialisteBundle(),
            new Sante\articleBundle\SantearticleBundle(),
            new JardinDenfant\ProfilJDBundle\JardinDenfantProfilJDBundle(),
            new JardinDenfant\EvenementBundle\JardinDenfantEvenementBundle(),
            new Loisirs\LoisirsBundle\LoisirsLoisirsBundle(),
            new Enseignant\EnseignantBundle\EnseignantEnseignantBundle(),
            new BabySitters\BabySittersBundle\BabySittersBabySittersBundle(),
            new Knp\Bundle\PaginatorBundle\KnpPaginatorBundle(),
            new Ivory\CKEditorBundle\IvoryCKEditorBundle(),
            new blackknight467\StarRatingBundle\StarRatingBundle(),
            new Stof\DoctrineExtensionsBundle\StofDoctrineExtensionsBundle(),
            new Discutea\DForumBundle\DForumBundle(),
            new Knp\Bundle\SnappyBundle\KnpSnappyBundle(),
            new MyApp\MailBundle\MyAppMailBundle(),
            new CMEN\GoogleChartsBundle\CMENGoogleChartsBundle(),
            new bsitterBundle\bsitterBundle(),
            new ContactsBundle\ContactsBundle(),
            new FOS\MessageBundle\FOSMessageBundle(),
            new FOS\JsRoutingBundle\FOSJsRoutingBundle(),
            new Vich\UploaderBundle\VichUploaderBundle(),
            new Vihuvac\Bundle\RecaptchaBundle\VihuvacRecaptchaBundle(),
            new Endroid\QrCode\Bundle\QrCodeBundle\EndroidQrCodeBundle(),

        ];

        if (in_array($this->getEnvironment(), ['dev', 'test'], true)) {
            $bundles[] = new Symfony\Bundle\DebugBundle\DebugBundle();
            $bundles[] = new Symfony\Bundle\WebProfilerBundle\WebProfilerBundle();
            $bundles[] = new Sensio\Bundle\DistributionBundle\SensioDistributionBundle();

            if ('dev' === $this->getEnvironment()) {
                $bundles[] = new Sensio\Bundle\GeneratorBundle\SensioGeneratorBundle();
                $bundles[] = new Symfony\Bundle\WebServerBundle\WebServerBundle();
            }
        }

        return $bundles;
    }

    public function getRootDir()
    {
        return __DIR__;
    }

    public function getCacheDir()
    {
        return dirname(__DIR__).'/var/cache/'.$this->getEnvironment();
    }

    public function getLogDir()
    {
        return dirname(__DIR__).'/var/logs';
    }

    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load($this->getRootDir().'/config/config_'.$this->getEnvironment().'.yml');
    }
}

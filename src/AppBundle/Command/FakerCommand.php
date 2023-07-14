<?php

namespace AppBundle\Command;

use AppBundle\Entity\Article;
use AppBundle\Entity\Attribute;
use AppBundle\Entity\Item;
use AppBundle\Entity\ItemAttribute;
use AppBundle\Entity\Selection;
use AppBundle\Entity\ItemSelection;
use AppBundle\Entity\User;

use AppBundle\Entity\Certificate;
use AppBundle\Entity\City;
use AppBundle\Entity\Clinic;
use AppBundle\Entity\ClinicAttr;
use AppBundle\Entity\ClinicAttrGroup;
use AppBundle\Entity\ClinicAttrLink;
use AppBundle\Entity\ClinicAttrVal;
use AppBundle\Entity\ClinicDisease;
use AppBundle\Entity\ClinicManipulation;
use AppBundle\Entity\ClinicMedDirection;
use AppBundle\Entity\ClinicParam;
use AppBundle\Entity\ClinicParamLink;
use AppBundle\Entity\ClinicParamVal;
use AppBundle\Entity\CostExample;
use AppBundle\Entity\Country;
use AppBundle\Entity\CountryDisease;
use AppBundle\Entity\CountryMedDirection;
use AppBundle\Entity\Curator;
use AppBundle\Entity\Disease;
use AppBundle\Entity\DiseaseCountry;
use AppBundle\Entity\Doctor;
use AppBundle\Entity\DoctorDegree;
use AppBundle\Entity\DoctorSpecialisation;
use AppBundle\Entity\LangSupport;
use AppBundle\Entity\LastRequest;
use AppBundle\Entity\Manipulation;
use AppBundle\Entity\MedDirection;
use AppBundle\Entity\Opinion;
use AppBundle\Entity\Page;
use AppBundle\Entity\PriceSegment;
use AppBundle\Entity\Promo;
use AppBundle\Entity\PromoMain;
use AppBundle\Entity\RelatedClinic;
use AppBundle\Entity\ServiceClinicType;
use Application\Sonata\MediaBundle\Entity\Media;
use Application\Sonata\MediaBundle\Entity\Gallery;
use Application\Sonata\MediaBundle\Entity\GalleryHasMedia;
use Faker\Factory;
use Faker\ORM\Doctrine\Populator;
use Sonata\MediaBundle\Entity\MediaManager;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * FakerCommand
 *
 * Класс реализует наполнение базы данных фиксинами
 */
class FakerCommand extends ContainerAwareCommand
{
    /**
     * @var array массив изображений
     */
    private $imgs;

    /**
     * @var int
     */
    private $imgCounter = 0;

    /**
     * @var string
     */
    private $fixtureImgsDir = __DIR__.'/../../../web/fixture_images/';

    /**
     * @var MediaManager
     */
    private $mediaManager;
    
    /**
     * Конфигурация
     *
     * @return void
     */
    protected function configure()
    {
        $this
            ->setName('vernal:faker')
            ->setDescription('Создание миксин')
        ;
        $this->imgs = scandir($this->fixtureImgsDir);
        array_shift($this->imgs);
        array_shift($this->imgs);
    }
    
    /**
     * Метод для связи многие ко многим между фикстурами
     *
     * @param array $entities
     * @param string $leftEntities
     * @param string $rightEntities
     * @param string $methodName
     *
     * @return void
     */
    public function manyToManyInsert($entities, $leftEntities, $rightEntities, $methodName)
    {
        $em = $this->getContainer()->get('doctrine')->getManager();
        
        foreach ($entities[$leftEntities] as $leftEntitity) {
            $randRightKeys = array_rand($entities[$rightEntities], random_int(1, count($entities[$rightEntities])));
            
            if (!is_array($randRightKeys)) {
                $randRightKeys = array($randRightKeys);
            }
            
            foreach ($randRightKeys as $randRightKey) {
                $leftEntitity->$methodName($entities[$rightEntities][$randRightKey]);
            }
            
            $em->persist($leftEntitity);
            $em->flush();
        }
    }
    
    /**
     * Метод для загрузки картинки в медиабандл
     *
     * @param string $context
     *
     * @return Media
     */
    public function addMediaImage($context)
    {
        $media = new Media;
        $media->setBinaryContent($this->fixtureImgsDir.$this->imgs[$this->imgCounter]);
        $media->setContext($context);
        $media->setProviderName('sonata.media.provider.image');
        $this->mediaManager->save($media);
        
        if ($this->imgCounter < count($this->imgs) - 1) {
            $this->imgCounter++;
        } else {
            $this->imgCounter = 0;
        }

        return $media;
    }


    /**
     * Метод для загрузки картинок в галерею медиабандла
     *
     * @param string $context
     *
     * @return Gallery
     */
    public function addGallery($context)
    {
        $gallery = new Gallery;
        $gallery->setContext($context);
        $gallery->setName($context.'-'.time());

        $this->getContainer()->get('sonata.media.manager.gallery')->save($gallery);

        for($i=0; $i<5; $i++) {
            $media = $this->addMediaImage($context);
            $galleryHasMedia = new GalleryHasMedia;
            $galleryHasMedia->setGallery($gallery);
            $galleryHasMedia->setMedia($media);
            $gallery->addGalleryHasMedias($galleryHasMedia);
        }
        $this->getContainer()->get('sonata.media.manager.gallery')->save($gallery);

        return $gallery;
    }
    /**
     * Метод для наполнения фикстурами. Будет выполнен при запуске из консоли.
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     *
     * @return null
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $em = $this->getContainer()->get('doctrine')->getManager();
        
        $imgRepo = $this->getContainer()->get('doctrine')->getRepository(Media::class);
        $imgs = $imgRepo->findAll();
        $generator = Factory::create('ru_RU');
        $populator = new Populator($generator, $em);
        $this->mediaManager = $this->getContainer()->get('sonata.media.manager.media');
        $countNewEnt = 5;
        
        /*$output->writeln('pages...');
        
        $populator->addEntity(Page::class, $countNewEnt, array(
            'name' => function () use ($generator) {
                return $generator->word;
            },
            'h1' => function () use ($generator) {
                return $generator->word;
            },
            'preview.type' => 'richhtml',
            'text.type' => 'richhtml',
            'deletedAt' => null,
        ));*/

        
        $output->writeln('users...');
        
        $populator->addEntity(User::class, $countNewEnt, array(
            'name' => function () use ($generator) {
                return $generator->word;
            },
            'password' => function () use ($generator) {
                return random_int(2000, 10000);
            },
            'plainPassword' => function () use ($generator) {
                return random_int(2000, 10000);
            },
            'image' => function () use ($imgs) {
                return $this->addMediaImage('media_context_user_image');
            },
            'deletedAt' => null,
        ));
        
        $output->writeln('articles...');
        
        $populator->addEntity(Article::class, $countNewEnt, array(
            'name' => function () use ($generator) {
                return $generator->company;
            },
            'gallery' => function () use ($imgs) {
                return $this->addGallery('media_context_article_image');
            },
            'previewType' => 'richhtml',
            'textType' => 'richhtml',
        ));

        $output->writeln('attributes...');
        
        $populator->addEntity(Attribute::class, $countNewEnt, array(
            'name' => function () use ($generator) {
                return $generator->word;
            },
        ));

        $output->writeln('selections...');
        
        $populator->addEntity(Selection::class, $countNewEnt, array(
            'name' => function () use ($generator) {
                return $generator->word;
            },
            'textType' => 'richhtml',
        ));

        $output->writeln('items...');
        
        $populator->addEntity(Item::class, $countNewEnt, array(
            'name' => function () use ($generator) {
                return $generator->word;
            },
            'link' => null,
            'discount' => function () use ($generator) {
                return random_int(0, 100);
            },
            'price' => function () use ($generator) {
                return random_int(2000, 10000);
            },
            'textType' => 'richhtml',
            'gallery' => function () use ($imgs) {
                return $this->addGallery('media_context_item_image');
            },
            'deletedAt' => null
        ));

        $output->writeln('item attributes...');
        
        $populator->addEntity(ItemAttribute::class, $countNewEnt, array(
            'value' => function () use ($generator) {
                return $generator->word;
            },
            'deletedAt' => null
        ));

        $output->writeln('item selections...');
        
        $populator->addEntity(ItemSelection::class, $countNewEnt, array(
            'deletedAt' => null
        ));
/*
        $output->writeln('cities...');
        
        $populator->addEntity(City::class, $countNewEnt, array(
            'name' => function () use ($generator) {
                return $generator->city;
            },
            'link' => null,
            'previewType' => 'richhtml',
            'textType' => 'richhtml',
            'deletedAt' => null
        ));
        
        $output->writeln('certificates...');
        
        $populator->addEntity(Certificate::class, $countNewEnt, array(
            'name' => function () use ($generator) {
                return $generator->sentence(random_int(2, 3));
            },
            'image' => function () use ($imgs) {
                return $this->addMediaImage('media_context_certificate');
            },
            'deletedAt' => null
        ));
        
        $output->writeln('curators...');
        
        $populator->addEntity(Curator::class, $countNewEnt, array(
            'name' => function () use ($generator) {
                return $generator->firstNameMale . ' ' . $generator->lastName;
            },
            'image' => function () use ($imgs) {
                return $this->addMediaImage('media_context_curator');
            },
            'deletedAt' => null,
            'responseTime' => function () use ($generator) {
                return random_int(1, 4);
            }
        ));
                
        $output->writeln('lang supports...');
        
        $populator->addEntity(LangSupport::class, $countNewEnt, array(
            'name' => function () use ($generator) {
                return $generator->sentence(random_int(2, 3));
            },
            'image' => function () use ($imgs) {
                return $this->addMediaImage('media_context_lang_support');
            },
            'deletedAt' => null
        ));
        
        $output->writeln('last requests...');
        
        $populator->addEntity(LastRequest::class, $countNewEnt, array(
            'fio' => function () use ($generator) {
                return $generator->firstNameMale . ' ' . $generator->lastName;
            },
            'textType' => 'richhtml',
            'status' => true,
            'deletedAt' => null
        ));
        
        $output->writeln('price segments...');
        
        $populator->addEntity(PriceSegment::class, $countNewEnt, array(
            'name' => function () use ($generator) {
                return $generator->sentence(random_int(2, 3));
            },
            'image' => function () use ($imgs) {
                return $this->addMediaImage('media_context_price_segment');
            },
            'deletedAt' => null
        ));
        
        $output->writeln('service types clinic...');
        
        $populator->addEntity(ServiceClinicType::class, $countNewEnt, array(
            'name' => function () use ($generator) {
                return $generator->sentence(random_int(2, 3));
            },
            'image' => function () use ($imgs) {
                return $this->addMediaImage('media_context_service_clinic_type');
            },
            'deletedAt' => null
        ));
        
        $output->writeln('doctor specialisations...');
        
        $populator->addEntity(DoctorSpecialisation::class, $countNewEnt, array(
            'name' => function () use ($generator) {
                return $generator->sentence(random_int(2, 3));
            },
            'image' => function () use ($imgs) {
                return $this->addMediaImage('media_context_doctor_specialisation');
            },
            'deletedAt' => null
        ));
        
        $output->writeln('doctor degrees...');
        
        $populator->addEntity(DoctorDegree::class, $countNewEnt, array(
            'name' => function () use ($generator) {
                return $generator->sentence(random_int(2, 3));
            },
            'image' => function () use ($imgs) {
                return $this->addMediaImage('media_context_doctor_degree');
            },
            'deletedAt' => null
        ));
        
        $output->writeln('clinic attr groups...');
        
        $populator->addEntity(ClinicAttrGroup::class, $countNewEnt, array(
            'name' => function () use ($generator) {
                return $generator->sentence(random_int(2, 3));
            },
            'deletedAt' => null
        ));
        
        $output->writeln('clinic attrs...');
        
        $populator->addEntity(ClinicAttr::class, $countNewEnt, array(
            'name' => function () use ($generator) {
                return $generator->sentence(random_int(2, 3));
            },
            'image' => function () use ($imgs) {
                return $this->addMediaImage('media_context_clinic_attr');
            },
            'deletedAt' => null
        ));
        
        $output->writeln('clinic params...');
        
        $populator->addEntity(ClinicParam::class, $countNewEnt, array(
            'name' => function () use ($generator) {
                return $generator->sentence(random_int(2, 3));
            },
            'paramType' => function () use ($generator) {
                return random_int(1, 3);
            },
            'deletedAt' => null
        ));
        
        $output->writeln('manipulations...');
        
        $populator->addEntity(Manipulation::class, $countNewEnt, array(
            'name' => function () use ($generator) {
                return $generator->sentence(random_int(2, 3));
            },
            'link' => function () use ($generator) {
                return $generator->word;
            },
            'previewType' => 'richhtml',
            'textType' => 'richhtml',
            'deletedAt' => null
        ));
        
        $output->writeln('clinics...');
        
        $populator->addEntity(Clinic::class, $countNewEnt, array(
            'name' => function () use ($generator) {
                return $generator->company;
            },
            'link' => null,
            'latitude' => function () use ($generator) {
                return random_int(0, 180) - 90;
            },
            'longitude' => function () use ($generator) {
                return random_int(0, 360) - 180;
            },
            'mapZoom' => function () use ($generator) {
                $scales = [10, 15, 20];
                return $scales[array_rand([10, 15, 20])];
            },
            'discount' => function () use ($generator) {
                return random_int(0, 100);
            },
            'quantityPatients' => function () use ($generator) {
                return random_int(0, 10000);
            },
            'previewType' => 'richhtml',
            'textType' => 'richhtml',
            'rating' => function () use ($generator) {
                return random_int(1, 5);
            },
            'deletedAt' => null
        ));
        
        $output->writeln('clinic param vals...');
        
        $populator->addEntity(ClinicParamVal::class, $countNewEnt, array(
            'val' => function () use ($generator) {
                return $generator->sentence(random_int(2, 3));
            },
            'deletedAt' => null
        ));
        
        $output->writeln('clinic attr vals...');
        
        $populator->addEntity(ClinicAttrVal::class, $countNewEnt, array(
            'val' => function () use ($generator) {
                return $generator->sentence(random_int(2, 3));
            },
            'deletedAt' => null
        ));*/
        /*
        $populator->addEntity(ClinicImage::class, $countNewEnt, array(
            'image' => function () use ($imgs) {
                return $this->addMediaImage('media_context_clinic_image');
            }
        ));
        
        $output->writeln('related clinics...');
        
        $populator->addEntity(RelatedClinic::class, $countNewEnt, array(
            'deletedAt' => null
        ));
        
        $output->writeln('med directions...');
        
        $populator->addEntity(MedDirection::class, $countNewEnt, array(
            'name' => function () use ($generator) {
                return $generator->sentence(random_int(2, 3));
            },
            'link' => null,
            'image' => function () use ($imgs) {
                return $this->addMediaImage('media_context_med_direction');
            },
            'previewType' => 'richhtml',
            'textType' => 'richhtml',
            'favouriteEtc' => true,
            'deletedAt' => null
        ));
        
        $output->writeln('diseases...');
        
        $populator->addEntity(Disease::class, $countNewEnt, array(
            'name' => function () use ($generator) {
                return $generator->sentence(random_int(2, 3));
            },
            'link' => null,
            'rating' => function () use ($generator) {
                return random_int(1, 5);
            },
            'technologies' => function () use ($generator) {
                return random_int(1, 100);
            },
            'previewType' => 'richhtml',
            'textType' => 'richhtml',
            'deletedAt' => null
        ));*/
        /*
        $populator->addEntity(DiseaseImage::class, $countNewEnt, array(
            'image' => function () use ($imgs) {
                return $this->addMediaImage('media_context_disease_image');
            }
        ));
        
        $populator->addEntity(DiseaseVideo::class, $countNewEnt);
        */
        /*
        $output->writeln('promos...');
        
        $populator->addEntity(Promo::class, $countNewEnt, array(
            'name' => function () use ($generator) {
                return $generator->sentence(random_int(2, 3));
            },
            'textType' => 'richhtml',
            'deletedAt' => null
        ));
        
        $output->writeln('promos main...');
        
        $populator->addEntity(PromoMain::class, $countNewEnt, array(
            'name' => function () use ($generator) {
                return $generator->sentence(random_int(2, 3));
            },
            'oldPrice' => function () use ($generator) {
                return random_int(4000, 5000);
            },
            'newPrice' => function () use ($generator) {
                return random_int(2000, 3000);
            },
            'discount' => function () use ($generator) {
                return random_int(1, 99);
            },
            'textType' => 'richhtml',
            'deletedAt' => null
        ));
        
        $output->writeln('doctors...');
        
        $populator->addEntity(Doctor::class, $countNewEnt, array(
            'name' => function () use ($generator) {
                return $generator->firstNameMale.' '.$generator->lastName;
            },
            'link' => function () use ($generator) {
                return $generator->word;
            },
            'experience' => function () use ($generator) {
                $currentYear = (int) date('Y');
                $targetYear = $currentYear - 60;
                return random_int($targetYear, $currentYear);
            },
            'previewType' => 'richhtml',
            'textType' => 'richhtml',
            'deletedAt' => null
        ));
        
        $output->writeln('cost examples...');
        
        $populator->addEntity(CostExample::class, $countNewEnt, array(
            'name' => function () use ($generator) {
                return $generator->sentence(random_int(2, 3));
            },
            'deletedAt' => null
        ));
        
        $output->writeln('country diseases...');
        
        $populator->addEntity(CountryDisease::class, $countNewEnt, array(
            'name' => function () use ($generator) {
                return $generator->sentence(random_int(2, 3));
            },
            'textType' => 'richhtml',
            'deletedAt' => null
        ));
        
        $output->writeln('country med directions...');
        
        $populator->addEntity(CountryMedDirection::class, $countNewEnt, array(
            'name' => function () use ($generator) {
                return $generator->sentence(random_int(2, 3));
            },
            'textType' => 'richhtml',
            'deletedAt' => null
        ));
        
        $output->writeln('opinions...');
        
        $populator->addEntity(Opinion::class, $countNewEnt, array(
            'name' => function () use ($generator) {
                return $generator->sentence(random_int(2, 3));
            },
            'link' => function () use ($generator) {
                return $generator->word;
            },
            'rating' => function () use ($generator) {
                return random_int(1, 5);
            },
            'ratingDoctor' => function () use ($generator) {
                return random_int(0, 10);
            },
            'ratingTranslator' => function () use ($generator) {
                return random_int(0, 10);
            },
            'ratingServices' => function () use ($generator) {
                return random_int(0, 10);
            },
            'fullPrice' => function () use ($generator) {
                return random_int(0, 1000);
            },
            'previewType' => 'richhtml',
            'textType' => 'richhtml',
            'answerType' => 'richhtml',
            'deletedAt' => null
        ));


        $output->writeln('articles...');
        
        $populator->addEntity(Article::class, $countNewEnt, array(
            'name' => function () use ($generator) {
                return $generator->company;
            },
            'gallery' => function () use ($imgs) {
                return $this->addGallery('media_context_article_image');
            },
            'previewType' => 'richhtml',
            'textType' => 'richhtml',
        ));
*/
        $output->writeln('GENERATION...');
        
        $insertedPKs = $populator->execute();
        
/*        $output->writeln('many to many:');
        
        $output->writeln('.certificates to clinics...');
        $this->manyToManyInsert($insertedPKs, Clinic::class, Certificate::class, 'addCertificate');
        
        $output->writeln('.service clinic types to clinics...');
        $this->manyToManyInsert($insertedPKs, Clinic::class, ServiceClinicType::class, 'addServiceClinicType');
        
        $output->writeln('.lang supports to clinics...');
        $this->manyToManyInsert($insertedPKs, Clinic::class, LangSupport::class, 'addLangSupport');
        
        $output->writeln('.manipulations to diseases...');
        $this->manyToManyInsert($insertedPKs, Disease::class, Manipulation::class, 'addManipulation');
        
        $output->writeln('.specialisations to doctors...');
        $this->manyToManyInsert($insertedPKs, Doctor::class, DoctorSpecialisation::class, 'addDoctorSpecialisation');
        
        $output->writeln('.med directions to opinions...');
        $this->manyToManyInsert($insertedPKs, Opinion::class, MedDirection::class, 'addMedDirection');
        
        $output->writeln('.med directions to diseases...');
        $this->manyToManyInsert($insertedPKs, Disease::class, MedDirection::class, 'addMedDirectionsFake');
        
        $output->writeln('check clinic attributes...');
        
        foreach ($insertedPKs[Clinic::class] as $leftEntitity) {
            $randRightKeys = $insertedPKs[ClinicAttr::class];
            
            if (!is_array($randRightKeys)) {
                $randRightKeys = array($randRightKeys);
            }
            
            foreach ($randRightKeys as $randRightKey => $randRightVal) {
                $attrId = $insertedPKs[ClinicAttr::class][$randRightKey]->getId();
                
                if (!$insertedPKs[ClinicAttr::class][$randRightKey]->getMultiVar()) {
                    $link = new ClinicAttrLink();
                    $link->setClinicId($leftEntitity->getId());
                    $link->setAttr($attrId);
                    $link->setVal(1);
                    $em->persist($link);
                    $em->flush();
                } else {
                    $vals = array();
                    $query = $em->createQuery('select cal.id from '.ClinicAttrVal::class.' as cal where cal.clinicAttr=:attr')->setParameter('attr', $attrId);
                    
                    foreach ($query->getResult() as $row) {
                        $vals[] = $row['id'];
                    }
                    
                    if (count($vals) > 0) {
                        $randVals = array_rand($vals, random_int(1, count($vals)));

                        if (!is_array($randVals)) {
                            $randVals = array($randVals);
                        }

                        foreach ($randVals as $randVal) {
                            $link = new ClinicAttrLink();
                            $link->setClinicId($leftEntitity->getId());
                            $link->setAttr($attrId);
                            $link->setVal($vals[$randVal]);
                            $em->persist($link);
                            $em->flush();
                        }
                    }
                }
            }
        }
        
        $output->writeln('check clinic params...');
        
        foreach ($insertedPKs[Clinic::class] as $leftEntitity) {
            $randRightKeys = $insertedPKs[ClinicParam::class];
            
            if (!is_array($randRightKeys)) {
                $randRightKeys = array($randRightKeys);
            }
            
            foreach ($randRightKeys as $randRightKey => $randRightVal) {
                $paramId = $insertedPKs[ClinicParam::class][$randRightKey]->getId();
                
                if ($insertedPKs[ClinicParam::class][$randRightKey]->getParamType() != 3) {
                    $link = new ClinicParamLink();
                    $link->setClinicId($leftEntitity->getId());
                    $link->setParam($paramId);

                    if ($insertedPKs[ClinicParam::class][$randRightKey]->getParamType() == 1) {
                        $link->setStrVal($generator->sentence(random_int(2, 3)));
                    } else {
                        $link->setIntVal(random_int(1, 1000));
                    }

                    $em->persist($link);
                    $em->flush();
                } else {
                    $vals = array();
                    $query = $em->createQuery('select cal.id from '.ClinicParamVal::class.' as cal where cal.clinicParam=:param')->setParameter('param', $paramId);
                    
                    foreach ($query->getResult() as $row) {
                        $vals[] = $row['id'];
                    }
                    
                    if (count($vals) > 0) {
                        $randVals = array_rand($vals, 1);

                        if (!is_array($randVals)) {
                            $randVals = array($randVals);
                        }

                        foreach ($randVals as $randVal) {
                            $link = new ClinicParamLink();
                            $link->setClinicId($leftEntitity->getId());
                            $link->setParam($paramId);
                            $link->setVal($vals[$randVal]);
                            $em->persist($link);
                            $em->flush();
                        }
                    }
                }
            }
        }
        
        $output->writeln('check clinic med directions...');
        
        foreach ($insertedPKs[Clinic::class] as $leftEntitity) {
            $query = $em->createQuery('select cal.id from '.MedDirection::class.' as cal');
            
            foreach ($query->getResult() as $row) {
                $link = new ClinicMedDirection();
                $link->setClinicId($leftEntitity->getId());
                $link->setMedDirectionId($row['id']);
                $link->setTextType('richhtml');
                $link->setTextRaw($generator->sentence(random_int(5, 30)));
                $link->setTextFormatted($generator->sentence(random_int(5, 30)));
                $em->persist($link);
                $em->flush();
            }
        }
        
        $output->writeln('check clinic diseases...');
        
        foreach ($insertedPKs[Clinic::class] as $leftEntitity) {
            $query = $em->createQuery('select cal.id from '.Disease::class.' as cal');
            
            foreach ($query->getResult() as $row) {
                $link = new ClinicDisease();
                $link->setClinicId($leftEntitity->getId());
                $link->setDiseaseId($row['id']);
                $link->setEnabled(random_int(0, 1));
                $link->setFavourite(random_int(0, 1));
                $em->persist($link);
                $em->flush();
            }
        }
        
        $output->writeln('check country diseases...');
        
        foreach ($insertedPKs[Disease::class] as $leftEntitity) {
            $query = $em->createQuery('select cal.id from '.Country::class.' as cal');
            
            foreach ($query->getResult() as $row) {
                $link = new DiseaseCountry();
                $link->setDiseaseId($leftEntitity->getId());
                $link->setCountryId($row['id']);
                $link->setEnabled(random_int(0, 1));
                $link->setFavourite(random_int(0, 1));
                $link->setTextType('richhtml');
                $link->setTextRaw($generator->sentence(random_int(5, 30)));
                $link->setTextFormatted($generator->sentence(random_int(5, 30)));
                $em->persist($link);
                $em->flush();
            }
        }
        */
        $output->writeln('Ok');
    }
}

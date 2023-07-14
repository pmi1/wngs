<?php

namespace Application\Sonata\MediaBundle\Provider;

use Sonata\MediaBundle\Provider\FileProvider as BaseFileProvider;
use Gaufrette\Filesystem;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\CoreBundle\Validator\ErrorElement;
use Sonata\MediaBundle\CDN\CDNInterface;
use Sonata\MediaBundle\Generator\GeneratorInterface;
use Sonata\MediaBundle\Metadata\MetadataBuilderInterface;
use Sonata\MediaBundle\Model\MediaInterface;
use Sonata\MediaBundle\Thumbnail\ThumbnailInterface;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotNull;

class SVGProvider extends BaseFileProvider
{
    /**
     * {@inheritdoc}
     */
    public function generatePublicUrl(MediaInterface $media, $format)
    {
        $path = $this->getReferenceImage($media);

        return $this->getCdn()->getPath($path, $media->getCdnIsFlushable());
    }
    
    /**
     * {@inheritdoc}
     */
    public function getReferenceImage(MediaInterface $media)
    {
        return sprintf('%s/%s', $this->generatePath($media), $media->getProviderReference());
    }
}

<?php

namespace Application\Sonata\MediaBundle\Resizer;

use Imagine\Image\Box;
use Imagine\Image\ImagineInterface;
use Imagine\Image\Point;
use Gaufrette\File;
use Sonata\MediaBundle\Model\MediaInterface;
use Sonata\MediaBundle\Resizer\ResizerInterface;
use Imagine\Image\ImageInterface;
use Imagine\Exception\InvalidArgumentException;
use Sonata\MediaBundle\Metadata\MetadataBuilderInterface;

class CustomResizer implements ResizerInterface
{
    protected $adapter;
    protected $mode;
    protected $metadata;

    /**
     * @param ImagineInterface $adapter
     * @param string $mode
     */
    public function __construct(ImagineInterface $adapter, $mode, MetadataBuilderInterface $metadata, $container)
    {
        $this->adapter = $adapter;
        $this->mode = $mode;
        $this->metadata = $metadata;
        $this->container = $container;
    }

    /**
     * {@inheritdoc}
     */
    public function resize(MediaInterface $media, File $in, File $out, $format, array $settings)
    {

        if (!(isset($settings['width']) && $settings['width']))
            throw new \RuntimeException(sprintf('Width parameter is missing in context "%s" for provider "%s"', $media->getContext(), $media->getProviderName()));

        $image = $this->adapter->load($in->getContent());
        $size = $media->getBox();

        if (null != $settings['height']) {
            if ($size->getHeight() > $size->getWidth()) {
                $higher = $size->getHeight();
                $lower = $size->getWidth();
            } else {
                $higher = $size->getWidth();
                $lower = $size->getHeight();
            }

            $crop = $higher - $lower;

            if ($crop > 0) {
                $point = $higher == $size->getHeight() ? new Point(0, 0) : new Point($crop / 2, 0);
                $image->crop($point, new Box($lower, $lower));
                $size = $image->getSize();
            }
        }

        $settings['height'] = (int) ($settings['width'] * $size->getHeight() / $size->getWidth());

        if ($settings['height'] < $size->getHeight() && $settings['width'] < $size->getWidth()) {
            $image = $image->thumbnail(new Box($settings['width'], $settings['height']), $this->mode);
        }

        $context_name = $media->getContext();
        if(in_array($context_name, [
            'media_context_item_image'
        ])
            && $settings['width'] > 400
        )
        {

            $imagine = new \Imagine\Gd\Imagine();

            $watermark = $imagine->open($this->container->getParameter('watermark'));

            $size      = $image->getSize();
            $wSize     = $watermark->getSize();

            if(($size->getWidth() >= $wSize->getWidth() + 30) && ($size->getHeight() > $wSize->getHeight() + 30)) {
                $bottomRight = new Point($size->getWidth() - $wSize->getWidth() - 30, $size->getHeight() - $wSize->getHeight() - 30);

                $image->paste($watermark, $bottomRight);
            }
        }


        $content = $image->get($format, array('quality' => $settings['quality']));

        $out->setContent($content, $this->metadata->get($media, $out->getName()));
    }

    public function getBox(MediaInterface $media, array $settings)
    {
        $size = $media->getBox();

        if (null != $settings['height']) {
            if ($size->getHeight() > $size->getWidth()) {
                $higher = $size->getHeight();
                $lower = $size->getWidth();
            } else {
                $higher = $size->getWidth();
                $lower = $size->getHeight();
            }

            if ($higher - $lower > 0) {
                return new Box($lower, $lower);
            }
        }

        $settings['height'] = (int) ($settings['width'] * $size->getHeight() / $size->getWidth());

        if ($settings['height'] < $size->getHeight() && $settings['width'] < $size->getWidth()) {
            return new Box($settings['width'], $settings['height']);
        }

        return $size;
    }
}
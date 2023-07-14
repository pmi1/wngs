<?php

namespace AppBundle\Interfaces;

/**
 * Interface PageInterface
 *
 * Интерфейс объявляет методы, которые должны быть обязательно реализованы у сущностей, которые будут иметь или уже имеют отдельную страницу на публичной части
 */
interface PageInterface
{
    /**
     * Устанавливаем мета тег title для элемента
     *
     * @param string $metaTitle
     */
    public function setMetaTitle($metaTitle);
        
    /**
     * Получаем мета тег title для элемента
     *
     * @return string
     */
    public function getMetaTitle();
    
    /**
     * Устанавливаем мета тег description для элемента
     *
     * @param string $metaDescription
     */
    public function setMetaDescription($metaDescription);
    
    /**
     * Получаем мета тег description для элемента
     *
     * @return string
     */
    public function getMetaDescription();
    
    /**
     * Устанавливаем мета тег keywords для элемента
     *
     * @param string $metaKeywords
     */
    public function setMetaKeywords($metaKeywords);
    
    /**
     * Получаем мета тег keywords для элемента
     *
     * @return string
     */
    public function getMetaKeywords();
    
    /**
     * Устанавливаем название элемента
     *
     * @param string $name
     */
    public function setName($name);
    
    /**
     * Получаем название элемента
     *
     * @return string
     */
    public function getName();
     
    /**
     * Устанавливаем урл элемента
     *
     * @param string $link
     */
    public function setLink($link);
    
    /**
     * Получаем урл элемента
     *
     * @return string
     */
    public function getLink();
    
    /**
     * Устанавливаем тип визуального редактора для краткого описания
     *
     * @param string $previewType
     */
    public function setPreviewType($previewType);
    
    /**
     * Получаем тип визуального редактора для краткого описания
     *
     * @return string
     */
    public function getPreviewType();
    
    /**
     * Устанавливаем тип визуального редактора для подробного описания
     *
     * @param string $textType
     */
    public function setTextType($textType);
    
    /**
     * Получаем тип визуального редактора для подробного описания
     *
     * @return string
     */
    public function getTextType();
    
    /**
     * Устанавливаем статус элемента
     *
     * @param bool $status
     */
    public function setStatus($status);
    
    /**
     * Получаем статус элемента
     *
     * @return bool
     */
    public function getStatus();
}

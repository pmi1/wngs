CONTRIBUTING
=============================

Coding Standards
------------

The project follows the standards defined in the PSR-0, PSR-1, PSR-2, PSR-4 documents and Symfony Standards https://symfony.com/doc/current/contributing/code/standards.html.

**Дополнительно:**
1. Добавить пустую строку перед и после циклов и условий, исключения составляют конструкции в начале метода класса или в конце метода класса и в начало и конец любых других циклов и условий.
2. Метод __toString помещать после конструктора класса.
3. Организовать структуру конфигурации согласно **Symfony Best Practice**.
4. Вместо конструкций, где надо указывать пространство имен класса, например, 
```php
$this->getDoctrine()->getRepository('AppBundle:CmfScript');
```
использовать конструкцию
```php
$this->getDoctrine()->getRepository(CmfScript::class);
```
6.	После открывающей скобки класса не должно быть пустых строк.
7.	Перед закрывающей скобкой класса не должно быть пустых строк.
8.	Не должно быть пустых строк после многострочных комментариев.
9.	Исключить любые закоментированые конструкции до блоков use и namespace.
10.	Имя переменной, поля, свойства, метода или функции не должно начинаться с нижнего подчеркивания, если это не магический метод класса.
11.	Должна быть одна пустая строка перед определением пространства имен класса.
```php
<?php

namespace AppBundle\Entity;
```
12. Использовать конструкцию use для подключения классов в комментариях и в коде  
Вместо:
```php
class SomeClass
{
    /**
     * Set video
     *
     * @deprecated 0.2
     * @param \Application\Sonata\MediaBundle\Entity\Media $video
     * @return Clinic
     */
    public function setVideo(\Application\Sonata\MediaBundle\Entity\Media $video = null)
    {
        $this->video = $video;

        return $this;
    }
}
```
Использовать:
```php
use Application\Sonata\MediaBundle\Entity\Media;

class SomeClass
{
    /**
     * Set video
     *
     * @deprecated 0.2
     * @param Media $video
     * @return Clinic
     */
    public function setVideo(Media $video = null)
    {
        $this->video = $video;

        return $this;
    }
}
```
13. Все стандартные сеттеры, а также remove методы в сущностях должны возвращать $this. Методы в сущностях не могут ничего не возвращать.
```php
/**
 * Remove certificate
 *
 * @param Certificate $certificate
 * @return SomeClass
 */
public function removeCertificate(Certificate $certificate)
{
    $this->certificate->removeElement($certificate);
    
    return $this;
}
```
14. Каждая сущность обязана иметь поле `$id`, а название столбца тоже такое же 'id'. Исключения составляют таблицы используемые для связи сущностей.  
Пример:
```php
/**
 * @var int
 *
 * @ORM\Column(name="id", type="integer")
 * @ORM\Id
 * @ORM\GeneratedValue(strategy="AUTO")
 */
private $id;
```
Пример исключения:
```php
/**
 * @var ArrayCollection|ServiceClinicType[]
 *
 * @ORM\ManyToMany(targetEntity="ServiceClinicType")
 * @ORM\JoinTable(name="clinic_service_clinic_type",
 *   joinColumns={@ORM\JoinColumn(name="clinic_id", referencedColumnName="clinic_id")},
 *   inverseJoinColumns={@ORM\JoinColumn(name="service_clinic_type_id", referencedColumnName="service_clinic_type_id")}
 * )
 */
private $serviceClinicType;
```
15. Названия полей в сущности при множественной привязке должны иметь множественное число, а также соответствующий PHPDOC.  
Пример:
```php
/**
 * @var ArrayCollection|Image[]
 *
 * @ORM\OneToMany(targetEntity="Image", mappedBy="someClass")
 */
private $images;
```
16. При использовании JavaScript, при навешивании любой магии на класс или id в вёрстке, название класса или id должно начинаться с префикса `js-`. При этом на такой класс или id нельзя назначать стили. 
17. Обязательная [декларация возвращаемого типа](http://php.net/manual/ru/functions.returning-values.php#functions.returning-values.type-declaration) там где это возможно (PHP 7).
18. Обязательная [декларация типов аргументов](http://php.net/manual/ru/functions.arguments.php#functions.arguments.type-declaration) там где это возможно (PHP 7).
19. Использовать суффикс `At` в названии поля, если тип поля относится к DateTime.
Пример:
```php
/**
 * @var \DateTime
 */
private $createdAt;

/**
 * @var \DateTime
 */
private $updatedAt;

/**
 * @var \DateTime
 */
private $deletedAt;
```
20. Запрещено использование пустых двойных кавычек для обозначения пустой строки. Вместо этого необходимо использовать тип данных null.  

Запрещено:
```php 
$result = '';
```
Разрешено:
```php 
$result = null;
```
21. Методы репозитория, которые возвращают данные из базы, должны начинаться со слова findOne или find в зависимости от того, один или несколько результатов возвращает метод.

Пример:
```php
class HospitalRepository
{
    public function findOnyByCountry()
    public function findByCountry(): array
}
```
22. Для роутинга на клиентской части использовать [FOSJsRoutingBundle](http://symfony.com/doc/current/bundles/FOSJsRoutingBundle/index.html)
23. Использовать DQL вместо SQL.
24. Использовать `"use strict";` в начале документа javascript.
25. Добавлять `declare(strict_types=1)` в начале php файла.
```php
<?php

declare (strict_types = 1);

namespace...
```
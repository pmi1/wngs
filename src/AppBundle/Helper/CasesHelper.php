<?php

namespace AppBundle\Helper;

use phpMorphy;
use Symfony\Component\ClassLoader\ClassLoader;

/**
 * Класс для склонения слов по падежам
 *
 *
 */
class CasesHelper extends AbstractHelper
{
    /**
     * @var string $encoding кодировка склоняемого слова(предложения)
     */
    private $encoding;
        
    /**
     * @var array $upperCaseMap карта регистров букв каждого слова: [номер слова][номер буквы] = регистр (1 - верхний, 0 - нижний)
     */
    private $upperCaseMap;
        
    /**
     * @var array $upperCaseWords слова исходного предложения в верхнем регистре
     */
    private $upperCaseWords;

    /**
     * CasesHelper constructor.
     */
    public function __construct()
    {
        $this->encoding = 'UTF-8';
        $this->upperCaseMap = [];
        $this->upperCaseWords = [];
    }
    
    /**
     * Метод склонения слов по падежам
     *
     * @param string $sentence исходное предложение
     *
     * @return array массив падежей с модифицированным предложением
     */
    public function generateCases(string $sentence): array
    {
        $result = [];
        $errors = [];
        $sentence = trim($sentence);
        $translator = $this->container->get('translator');
        
        if (mb_strlen($sentence) > 0) {
            /* Ключи нужных нам падежей */
            $cases = array('РД', 'ДТ', 'ВН', 'ТВ', 'ПР');
            
            $morphy = $this->initMorphy();
            $this->parseSentence($sentence);
            
            /* Пытаемся просклонять каждое слово. Если не получается - сохраняем исходное */
            foreach ($cases as $case) {
                $newArray = [];
                
                foreach ($this->upperCaseWords as $index => $word) {
                    $errStatus = false;
                    $paradigms = $morphy->castFormByGramInfo($word, null, array($case), false);

                    if (isset($paradigms[0]) && isset($paradigms[0]['form'])) {
                        $newArray[] = $this->mapWordByUppercase($paradigms[0]['form'], $this->upperCaseMap[$index]);
                    } else {
                        $newArray[] = $this->mapWordByUppercase($word, $this->upperCaseMap[$index]);
                        $errStatus = true;
                    }

                    if ($errStatus) {
                        $errors[$index] = $translator->trans('Convertation error') . ':' . $this->mapWordByUppercase($word, $this->upperCaseMap[$index]);
                    }
                }
                
                $result['content'][$case] = implode(' ', $newArray);
            }
        } else {
            $errors[] = $translator->trans('Convertation impossible');
        }
        
        if (count($errors)) {
            $result['errors'] = implode('<br/>', $errors);
        } else {
            $result['done'] = $translator->trans('Convertation is done');
        }
        
        return $result;
    }
    
    /**
     * Парсим исходное предложение на слова, составляем карту регистров
     *
     * @param string $sentence предложение
     */
    public function parseSentence(string $sentence)
    {
        /* Сохраняем регистр каждой буквы исходного слова и переводим все слова в верхний регистр для phpmorphy */
        $words = explode(' ', $sentence);

        foreach ($words as $index => $word) {
            $wordLength = mb_strlen($word);

            for ($i=0; $i<$wordLength; $i++) {
                $letter = mb_substr($word, $i, 1, $this->encoding);
                $this->upperCaseMap[$index][$i] = ($letter == mb_strtoupper($letter, $this->encoding));
                $this->upperCaseWords[$index] = mb_strtoupper($word, $this->encoding);
            }
        }
    }
    
    /**
     * Приводим буквы в слове к исходному регистру
     *
     * @param string $word слово
     * @param array $map карта регистров: ключ - номер буквы в слове, значение - регистр (1 - верхний, 0 - нижний)
     *
     * @return string
     */
    public function mapWordByUppercase(string $word, array $map): string
    {
        $newWord = '';
        
        $wordLength = mb_strlen($word);

        for ($i = 0; $i<$wordLength; $i++) {
            $letter = mb_substr($word, $i, 1, $this->encoding);

            if (isset($map[$i]) && $map[$i]) {
                $newWord .= mb_strtoupper($letter, $this->encoding);
            } else {
                $newWord .= mb_strtolower($letter, $this->encoding);
            }
        }
        
        return $newWord;
    }
    
    /**
     * Инициализируем phpMorphy
     *
     * @return phpMorphy
     */
    private function initMorphy():phpMorphy
    {
        $loader = new ClassLoader();
        $loader->addPrefix('phpMorphy', $this->container->get('kernel')->getRootDir().'/../bin/phpmorphy/src/common.php');
        $loader->register();
        
        $dir = $this->container->get('kernel')->getRootDir() . '/../bin/phpmorphy/dicts';
        $lang = 'ru_RU';
        $opts = ['storage' => 'file'];

        return new phpMorphy($dir, $lang, $opts);
    }
}

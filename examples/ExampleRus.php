<?php

namespace cphr\SimpleCipher\Examples;

require __DIR__ . '/../vendor/autoload.php';

use cphr\SimpleCipher\SimpleCipher;

class ExampleRus
{
    private array $config = [
        'symbols' => [
            'А', 'а', 'Б', 'б', 'В', 'в', 'Г', 'г', 'Д', 'д',
            'Е', 'е', 'Ё', 'ё', 'Ж', 'ж', 'З', 'з', 'И', 'и',
            'Й', 'й', 'К', 'к', 'Л', 'л', 'М', 'м', 'Н', 'н',
            'О', 'о', 'П', 'п', 'Р', 'р', 'С', 'с', 'Т', 'т',
            'У', 'у', 'Ф', 'ф', 'Х', 'х', 'Ц', 'ц', 'Ч', 'ч',
            'Ш', 'ш', 'Щ', 'щ', 'Ь', 'ь', 'Ы', 'ы', 'Ъ', 'ъ',
            'Э', 'э', 'Ю', 'ю', 'Я', 'я',
        ],
        'type' => 'sha1',
        'position' => 2,
        'variables' => 4,
        'length' => 6
    ];

    private string $data;

    /**
     * @param string $data
     * @return void
     */
    public function setData(string $data): void
    {
        $this->data = $data;
    }

    /**
     * @param string $data
     * @return string
     */
    public function showData(string $data): string
    {
        $example = '--------------------------------------------------' . PHP_EOL;
        $example .= $data . PHP_EOL;
        return $example;
    }

    /**
     * @return string
     */
    public function getCipheredData(): string
    {
        $cipher = new SimpleCipher();
        $cipher->setConfig($this->config);
        return $cipher->enCipher($this->data);
    }

    /**
     * @return string
     */
    public function getDeCipheredData(): string
    {
        $cipher = new SimpleCipher();
        $cipher->setConfig($this->config);
        return $cipher->deCipher($this->data);
    }
}

$example = new ExampleRus();
$example2 = $example3 = clone $example;

$data = 'Шифровальщица попросту забыла ряд ключевых множителей и тэгов: 0123456789';
echo $example->showData($data);

$example2->setData($data);
$cipheredData = $example2->getCipheredData();
echo $example2->showData($cipheredData);

$example3->setData($cipheredData);
$decipheredData = $example3->getDeCipheredData();
echo $example3->showData($decipheredData);

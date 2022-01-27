<?php

namespace cphr\SimpleCipher\Examples;

require __DIR__ . '/../vendor/autoload.php';

use cphr\SimpleCipher\SimpleCipher;

class Example
{
    private array $config = [];

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

$example = new Example();
$example2 = $example3 = clone $example;

$data = "THE QUICK BROWN FOX JUMPED OVER THE LAZY DOG'S BACK 1234567890";
echo $example->showData($data);

$example2->setData($data);
$cipheredData = $example2->getCipheredData();
echo $example2->showData($cipheredData);

$example3->setData($cipheredData);
$decipheredData = $example3->getDeCipheredData();
echo $example3->showData($decipheredData);

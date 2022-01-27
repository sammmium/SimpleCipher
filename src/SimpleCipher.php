<?php

namespace cphr\SimpleCipher;

use cphr\SimpleCipher\iSimpleCipher;

class SimpleCipher implements iSimpleCipher
{
    private array $defaultConfig = [
        'secretWord' => 'SimpleCipher',
        'symbols' => [
            'A', 'a', 'B', 'b', 'C', 'c', 'D', 'd', 'E', 'e',
            'F', 'f', 'G', 'g', 'H', 'h', 'I', 'i', 'J', 'j',
            'K', 'k', 'L', 'l', 'M', 'm', 'N', 'n', 'O', 'o',
            'P', 'p', 'Q', 'q', 'R', 'r', 'S', 's', 'T', 't',
            'U', 'u', 'V', 'v', 'W', 'w', 'X', 'x', 'Y', 'y',
            'Z', 'z',

            '0', '1', '2', '3', '4', '5', '6', '7', '8', '9',

            '~', '`', '!', '@', '"', '#', '№', '$', ';', '%',
            '^', ':', '&', '?', '*', '(', ')', '-', '_', '+',
            '=', "'", '[', ']', '{', '}', '\\', '|', '/', ',',
            '.', '<', '>', ' ',
        ],
        'type' => 'sha1',
        'position' => 5,
        'variables' => 5,
        'length' => 5
    ];

    /*
     * All ciphered symbols in one column
     *
     * [
     *     'cipher1' => 'a',
     *     'cipher2' => 'a',
     *     'cipher3' => 'a',
     *     'cipher4' => 'a',
     *     '...' => 'a',
     *     'cipher28' => 'c',
     *     '...'
     * ]
     */
    private array $cipheredSymbolsSymbols = [];

    /*
     * All ciphered symbols separated and grouped by each symbol
     *
     * [
     *     'a' => [
     *         'cipher1',
     *         'cipher2',
     *         'cipher3',
     *         'cipher4',
     *         ...
     *     ],
     *     'b' => [...],
     *     ...
     * ]
     */
    private array $symbolsCipheredSymbols = [];

    private array $config = [];

    /**
     * @param array $config
     * @return void
     */
    public function setConfig(array $config = []): void
    {
        if (count($config)) {
            $this->config = $this->defaultConfig;
            foreach ($config as $key => $value) {
                if ($key == 'symbols') {
                    $this->config[$key] = array_merge($this->config[$key], $value);
                } else {
                    $this->config[$key] = $value;
                }
            }
        }
    }

    /**
     * @param string $data
     * @return string
     */
    public function enCipher(string $data): string
    {
        if (!count($this->config)) {
            return $data;
        }
        $result = [];
        $this->prepareCipheredSymbols();
        foreach (mb_str_split($data) as $item) {
            $result[] = $this->getRandomCipheredSymbol($item);
        }
        return implode(' ', $result);
    }

    /**
     * @param string $data
     * @return string
     */
    public function deCipher(string $data): string
    {
        if (!count($this->config)) {
            return $data;
        }
        $result = [];
        $this->prepareCipheredSymbols();
        $value = explode(' ', $data);
        foreach ($value as $item) {
            $result[] = $this->cipheredSymbolsSymbols[$item];
        }
        return implode($result);
    }

    /**
     * @return array
     */
    public function getConfig(): array
    {
        return $this->config;
    }

    /**
     * @return array
     */
    private function getSeparatedSecretWord(): array
    {
        $templateArray = str_split($this->config['secretWord']);
        if (count($templateArray) < $this->config['position']) {
            return [
                'firstPart' => implode($templateArray),
                'secondPart' => '',
            ];
        }
        $firstPart = '';
        foreach ($templateArray as $i => $item) {
            if ($i < $this->config['position']) {
                $firstPart .= $item;
                unset($templateArray[$i]);
            }
        }
        $secondPart = implode($templateArray);
        unset($templateArray);
        return [
            'firstPart' => $firstPart,
            'secondPart' => $secondPart,
        ];
    }

    /**
     * @return void
     */
    private function prepareCipheredSymbols()
    {
        foreach ($this->config['symbols'] as $symbol) {
            $this->setCipheredSymbols($symbol);
        }
    }

    /**
     * @param string $symbol
     * @return void
     */
    private function setCipheredSymbols(string $symbol): void
    {
        $hashedSymbol = $this->getHashedItem($symbol);
        for ($shift = 0; $shift < $this->config['variables']; $shift++) {
            $cipheredSymbol = $this->getShiftedCipheredSymbol($hashedSymbol, $shift);
            if (array_key_exists($cipheredSymbol, $this->cipheredSymbolsSymbols) === false) {
                $this->cipheredSymbolsSymbols[$cipheredSymbol] = $symbol;
                $this->symbolsCipheredSymbols[$symbol][] = $cipheredSymbol;
            }
        }
    }

    /**
     * @param string $symbol
     * @return string
     */
    private function getHashedItem(string $symbol): string
    {
        $templateParts = $this->getSeparatedSecretWord();
        $type = $this->config['type'];
        return $type($templateParts['firstPart'] . $symbol . $templateParts['secondPart']);
    }

    /**
     * @param string $hashedSymbol
     * @param int $shift
     * @return string
     */
    private function getShiftedCipheredSymbol(string $hashedSymbol, int $shift): string
    {
        $length = $this->config['length'];
        return substr($hashedSymbol, $shift, $length);
    }

    /**
     * @param $item
     * @return string
     */
    private function getRandomCipheredSymbol($item): string
    {
        $variablesCipheredSymbol = $this->symbolsCipheredSymbols[$item];
        $countVariables = count($variablesCipheredSymbol) - 1;
        $random = rand(0, $countVariables);
        return $variablesCipheredSymbol[$random];
    }
}

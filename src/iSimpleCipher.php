<?php

namespace cphr\SimpleCipher;

interface iSimpleCipher
{
    /**
     * If an array of configurations is empty
     * then will be return input data without changing.
     *
     * @param array $config Configurations for ciphering and deciphering
     * @return void
     */
    public function setConfig(array $config = []) : void;

    /**
     * Get ciphered or not changed data in depends on configurations.
     * Input data will be without tabs and line breaks.
     *
     * @param string $data Text value
     * @return string Ciphered or not changed data
     */
    public function enCipher(string $data) : string;

    /**
     * Get deciphered or not changed (ciphered) data in depends on configurations.
     *
     * @param string $data Ciphered data
     * @return string Deciphered or not changed (ciphered) data
     */
    public function deCipher(string $data) : string;
}

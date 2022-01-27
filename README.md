Simple Cipher
=============

This library provide an opportunity to ciphering text before 
saving to the database and to deciphering it back to simple text.

INSTALLATION
------------

Using Composer.

    composer require sammmium/simple_cipher

REQUIREMENTS
------------

The minimum requirement by Simple Cipher is supporting PHP 7.4
or above. Simple Cipher has been tested with Apache HTTP server
on Ubuntu operating systems.

TESTING
-------

Using console commands. There are three examples for testing Simple Cipher.

First example show you how it works without configurations. In 
this situation input text will be returned without changes.

    php examples/Example.php

Second example is for testing Simple Cipher with English alphabet 
(default configuration).

    php examples/ExampleEng.php

Third example is for testing Simple Cipher with Russian alphabet.
At the same way you can use other languages by filling configurations.

    php examples/ExampleRus.php

USING
-----

### Including class
First of all, you will need to include the SimpleCipher class.
    
    use cphr\SimpleCipher\SimpleCipher;

### Preparing configurations
Moreover, you will need to populate an array of configurations 
that need to be sent to the Simple Cipher object. Next example will
show you how could be seen an array of configuration with default
language (English).

    $config = [
        'type' => 'md5',
        'position' => 3,
        'variables' => 7,
        'length' => 5
    ];

If you want to use for example Russian then you will add to configurations
an alphabet like an array. Custom configuration of symbols purpose to 
extending an array of default symbols. It is show in the next example.

    $config = [
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
    ]

The parameter `type` is purposed to determine the type of encryption. It
could be `sha1` or `md5`.

The parameter `position` is purposed to preparing hashed string of symbol
which is ciphering.

The parameter `variables` is purposed to determine of variants of each 
ciphering symbol.

The parameter `length` is purposed to determine of length of visible (storable)
ciphered symbol.

There is default parameter which called `secretWord` and has the next value: 
`SimpleCipher`. It is purposed to preparing hashed string of symbol
which is ciphering too. For safety reasons, it could to be changed.
    
    $config = [
        'secretWord' => 'yourOwnSecretWord',
        ...
    ]

> Input data can be ciphered and deciphered only with the same configurations!!!

### Preparing text (message / password / coordinates / etc.)
You will prepare a text. Input data will be without tabs and line breaks.

    $data = "THE QUICK BROWN FOX JUMPED OVER THE LAZY DOG'S BACK 0123456789";

### Ciphering
After that you will need to use the Simple Cipher object. Send to 
the Simple Cipher object `$config` (some default parameters would be 
overwritten by custom parameters). And feed to a method `enCipher` 
of the Simple Cipher object your `$data`.

    $cipher = new SimpleCipher();
    $cipher->setConfig($config);
    return $cipher->enCipher($data);

### Result of ciphering
In the result it will be returned a ciphered data. It will look something like this 
(in one line):

    56ed3 fb034 eb668 c9812 4743a fc852 f7263 5f955 58e85 c9812 62cdf a3f0e 
    7a1aa d81f2 04184 c9812 1202c a1aa4 24009 98124 f5356 f7fc8 43441 ad9f5 
    aeb66 17af1 40707 4188f d1d13 8fcd5 29ca3 81240 6d58d 4e768 668fc 40707 
    85f0c 9f6ef f4757 8bd91 c9812 f1b81 7a1aa cd1ea e433d 9e3f7 98124 2cdfc 
    ef7e2 55f18 1df58 98124 e4f4f c346c b6629 a32d1 5cf8f a2690 c54a5 d92ef 
    e3930 4e2f5

> Ciphered data could be better to store somewhere to the database.

### Deciphering
For deciphering of ciphered data you will feed that ciphered data to a method 
`deCipher`.

    $cipher = new SimpleCipher();
    $cipher->setConfig($config);
    return $cipher->deCipher($cipheredData);

### Result of deciphering
In the result it will be returned a deciphered data:

    THE QUICK BROWN FOX JUMPED OVER THE LAZY DOG'S BACK 1234567890

WHAT's NEXT
-----------

In the nearest future this library may be extended and improved:
* tabs and line breaks do not matter in the input text
* input data will not be only ciphered but prepared query and bindings for 
inserting and updating data into the database

P.S.:
-----
I hope that if this library will be useful and convenient for you and of 
your projects, so you will send me your feedback to my email. 

Your lonely-lonely-loner-developer )

**Eugeny Samoilov** 

***sammmium.dev@gmail.com***

Minsk 2022
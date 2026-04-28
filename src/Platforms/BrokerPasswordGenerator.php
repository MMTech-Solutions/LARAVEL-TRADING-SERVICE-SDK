<?php

namespace Mmt\TradingServiceSdk\Platforms;

class BrokerPasswordGenerator
{
    public static function generateRandomPassword(): string
    {
        // Genera una contraseña con al menos una letra minúscula, una letra mayúscula,
        // un número y un carácter especial permitido.
        $allowedSpecials = '!\"#$%&\'()*+,-./:;<=>?@[\\]^_`{|}~';
        $specialChars = str_split($allowedSpecials);

        $lower = chr(random_int(97, 122)); // a-z
        $upper = chr(random_int(65, 90));  // A-Z
        $digit = chr(random_int(48, 57));  // 0-9
        $special = $specialChars[random_int(0, count($specialChars) - 1)];

        $length = 12;
        $all = array_merge(
            range('a', 'z'),
            range('A', 'Z'),
            range('0', '9'),
            $specialChars
        );

        $password = [$lower, $upper, $digit, $special];

        for ($i = 4; $i < $length; $i++) {
            $password[] = $all[random_int(0, count($all) - 1)];
        }

        // Fisher-Yates con random_int para mantener CSPRNG en todo el proceso.
        for ($i = count($password) - 1; $i > 0; $i--) {
            $j = random_int(0, $i);
            [$password[$i], $password[$j]] = [$password[$j], $password[$i]];
        }

        return implode('', $password);
    }
}

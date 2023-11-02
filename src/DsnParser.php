<?php

class DsnParser
{
    /**
     * Parse DSN strings from the environment variables.
     *
     * @param bool $setEnv If true, will also set the parsed values as environment variables.
     * @return array An associative array of the parsed DSNs.
     */
    public static function parse($setEnv = true)
    {
        $dsns = [];

        // Filter out environment variables starting with "DSN_"
        foreach ($_ENV as $key => $value) {
            if (strpos($key, 'DSN_') === 0) {
                $details = [];
                $pairs = explode(';', $value); // Split string by semicolon

                // Split each pair into key and value
                foreach ($pairs as $pair) {
                    list($k, $v) = explode('=', $pair);
                    $details[$k] = $v;

                    // Set each parameter as an environment variable if $setEnv is true
                    if ($setEnv) {
                        putenv("$k=$v");
                    }
                }

                $dsns[strtolower(substr($key, 4))] = $details;
            }
        }

        return $dsns;
    }
}

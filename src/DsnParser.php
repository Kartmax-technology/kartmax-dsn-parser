<?php

namespace DsnParser;
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
        foreach ($_ENV as $key => $value) {
            if (strpos($key, '_DSN_') !== false) {
                // Remove 'MYSQL_' and 'DSN_' to get the prefix, e.g., "VX_CART_"
                $prefix = preg_replace('/^MYSQL_/', '', strstr($key, 'DSN_', true));

                // Parse the DSN string into components
                $parsedUrl = parse_url($value);
                $path = ltrim($parsedUrl['path'], '/'); // Remove the leading slash

                // Extract the query string parameters like charset
                $query = [];
                if (isset($parsedUrl['query'])) {
                    parse_str($parsedUrl['query'], $query);
                }

                // Map the components to the $_ENV superglobal
                $envMapping = [
                    'host' => "{$prefix}HOST",
                    'port' => "{$prefix}PORT",
                    'user' => "{$prefix}USERNAME",
                    'pass' => "{$prefix}PASSWORD",
                    'path' => "{$prefix}DATABASE",
                ];

                foreach ($envMapping as $component => $envKey) {
                    $valueToSet = $component === 'path' ? $path : ($parsedUrl[$component] ?? null);
                    if ($valueToSet !== null && $setEnv) {
                        $_ENV[$envKey] = $valueToSet;
                        $dsns[$envKey] = $valueToSet;
                    }
                }

                // Set additional parameters like 'charset'
                foreach ($query as $param => $value) {
                    $envKey = "{$prefix}DB_" . strtoupper($param);
                    if ($setEnv) {
                        $_ENV[$envKey] = $value;
                        $dsns[$envKey] = $value;
                    }
                }
            }
        }
        return $dsns;
    }
}

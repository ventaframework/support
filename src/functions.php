<?php declare(strict_types = 1);

if (!function_exists('array_dot_get')) {
    /**
     * Array dot access get function
     *
     * @param  array $array
     * @param  string $key
     * @param  null $default
     * @return mixed
     */
    function array_dot_get(array $array, string $key, $default = null)
    {
        $map = explode('.', $key);
        $key = array_shift($map);

        if (array_key_exists($key, $array)) {
            if (is_array($array[$key]) && count($map) > 0) {
                return array_dot_get($array[$key], implode('.', $map), $default);
            }

            return count($map) > 0 ? $default : $array[$key];
        }

        return $default;
    }
}

if (!function_exists('array_dot_set')) {
    /**
     * Array dot access value setter
     *
     * @param array $array
     * @param string $key
     * @param $value
     */
    function array_dot_set(array &$array, string $key, $value)
    {
        $map = explode('.', $key);

        while (count($map) > 1) {
            $key = array_shift($map);

            if (!array_key_exists($key, $array) || !is_array($array[$key])) {
                $array[$key] = [];
            }

            $array = &$array[$key];
        }

        $array[array_shift($map)] = $value;
    }
}

if (!function_exists('array_dot_has')) {
    /**
     * Defines if item exists in array, using dot notation
     *
     * @param  array $array
     * @param  string $key
     * @return bool
     */
    function array_dot_has(array $array, string $key): bool
    {
        $map = explode('.', $key);

        while (count($map) > 0) {
            $key = array_shift($map);

            if (!array_key_exists($key, $array) || (count($map) > 0 && !is_array($array[$key]))) {
                return false;
            }

            $array = $array[$key];
        }

        return true;
    }
}

if (!function_exists('array_dot_remove')) {
    /**
     * Remove value from an array using dot notation
     *
     * @param array $array
     * @param string $key
     */
    function array_dot_remove(array &$array, string $key)
    {
        $map = explode('.', $key);

        while (count($map) > 1) {
            $key = array_shift($map);

            if (!array_key_exists($key, $array) || !is_array($array[$key])) {
                return;
            }

            $array = &$array[$key];
        }

        $key = array_shift($map);
        if (array_key_exists($key, $array)) {
            unset($array[$key]);
        }
    }
}
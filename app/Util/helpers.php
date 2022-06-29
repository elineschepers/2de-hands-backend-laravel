<?php

/**
 * This file contains custom helper functions
 */

/**
 * Checks if a valid locale is present in the selected attribute
 * of the given request instance.
 *
 * @param string $attr
 * @return bool
 * @throws \Psr\Container\ContainerExceptionInterface
 * @throws \Psr\Container\NotFoundExceptionInterface
 */
function checkValidLocaleInRequest(string $attr): bool
{
    $request = request();

    if (!$request->has($attr)) {
        return false;
    }

    $items = $request->get($attr);

    if (!is_array($items)) {
        return false;
    }

    foreach (config('shop.supported_languages') as $key => $lang) {
        // If the key exists and the value is not empty we know there is a valid locale
        if (array_key_exists($key, $items) && !empty(trim($items[$key]))) {
            return true;
        }
    }

    return false;
}

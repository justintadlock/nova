<?php

namespace Nova\Yaml;

use Symfony\Component\Yaml\Yaml;

class FrontMatter
{
    public static function parse( $content)
    {
        $pattern = '/^[\s\r\n]?---[\s\r\n]?$/sm';

        $parts = preg_split($pattern, PHP_EOL.ltrim($content));

        if (count($parts) < 3) {
            return new Document([], $content);
        }

        $matter = Yaml::parse(trim($parts[1]));

        $body = implode(PHP_EOL.'---'.PHP_EOL, array_slice($parts, 2));

        return new Document($matter, $body);
    }

    public static function parseFile( $path)
    {
        return static::parse(
            file_get_contents($path)
        );
    }
}

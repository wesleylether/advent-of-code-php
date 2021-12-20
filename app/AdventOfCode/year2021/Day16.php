<?php
declare(strict_types=1);

namespace App\AdventOfCode\year2021;

use App\AdventOfCode\BaseAdventOfCodeDay;
use function array_map;
use function array_product;
use function array_splice;
use function array_sum;
use function base_convert;
use function implode;
use function str_split;

final class Day16 extends BaseAdventOfCodeDay
{
    public function one(): void
    {
        $bin = $this->getData($this->input[0]);
        $rootPacket = $this->process($bin);

        $this->info(
            'Decode the structure of your hexadecimal-encoded BITS transmission; what do you get if you add up the version numbers in all packets?',
        );
        $this->line($this->sumVersions($rootPacket));
    }

    public function two(): void
    {
        $bin = $this->getData($this->input[0]);
        $rootPacket = $this->process($bin);

        $this->info(
            'What do you get if you evaluate the expression represented by your hexadecimal-encoded BITS transmission?',
        );
        $this->line($rootPacket['value']);
    }

    protected function process(array &$binary): array
    {
        $version = $this->read($binary, 3);
        $typeID = $this->read($binary, 3);
        $packet = ['version' => $version, 'typeID' => $typeID, 'packets' => []];

        if ($typeID === 4) {
            $number = '';
            do {
                $type = $this->read($binary);
                $number .= $this->read($binary, 4, true);
            } while ($type !== 0);
            return [...$packet, 'value' => base_convert($number, 2, 10)];
        }

        $lengthID = $this->read($binary);
        switch ($lengthID) {
            case 0:
                $length = $this->read($binary, 15);
                $bits = array_splice($binary, 0, $length);
                while (count($bits) > 0) {
                    $packet['packets'][] = $this->process($bits);
                }
                break;
            case 1:
                $count = $this->read($binary, 11);
                while ($count > 0) {
                    $packet['packets'][] = $this->process($binary);
                    $count--;
                }
                break;
        }

        $subValues = array_map(
            static fn($subPacket) => $subPacket['value'],
            $packet['packets'],
        );

        switch ($typeID) {
            case 0:
                $packet['value'] = array_sum($subValues);
                break;
            case 1:
                $packet['value'] = array_product($subValues);
                break;
            case 2:
                $packet['value'] = min($subValues);
                break;
            case 3:
                $packet['value'] = max($subValues);
                break;
            case 5:
                $packet['value'] = $subValues[0] > $subValues[1] ? 1 : 0;
                break;
            case 6:
                $packet['value'] = $subValues[0] < $subValues[1] ? 1 : 0;
                break;
            case 7:
                $packet['value'] = $subValues[0] === $subValues[1] ? 1 : 0;
                break;
        }

        return $packet;
    }

    protected function read(
        array &$binary,
        int $nBits = 1,
        bool $returnBitString = false,
    ): int|string {
        $bits = array_splice($binary, 0, $nBits);

        if ($returnBitString) {
            return implode($bits);
        }

        return (int) base_convert(implode($bits), 2, 10);
    }

    protected function sumVersions(array $packet): int
    {
        $packetsVersionSum = 0;
        foreach ($packet['packets'] as $subPacket) {
            $packetsVersionSum += $this->sumVersions($subPacket);
        }
        return $packet['version'] + $packetsVersionSum;
    }

    protected function getData(string $hex): array
    {
        $bin = [];
        foreach (str_split($hex) as $hexChar) {
            $bin[] = match ($hexChar) {
                '0' => '0000',
                '1' => '0001',
                '2' => '0010',
                '3' => '0011',
                '4' => '0100',
                '5' => '0101',
                '6' => '0110',
                '7' => '0111',
                '8' => '1000',
                '9' => '1001',
                'A' => '1010',
                'B' => '1011',
                'C' => '1100',
                'D' => '1101',
                'E' => '1110',
                'F' => '1111'
            };
        }

        return str_split(implode($bin));
    }
}

<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use App\RandomCodesGenerator;
use App\Exceptions\InvaliidParametersException;

class RandomCodesGeneratorTest extends TestCase
{
    /**
     *  @dataProvider dataToTestGenerateCode
     *
     * @return void
     */
    public function testGenerateCode(int $lenghtOfCode): void
    {
        $randomCodesGenerator = new RandomCodesGenerator();
        $code = $randomCodesGenerator->generateCode($lenghtOfCode);

        $this->assertEquals($lenghtOfCode, mb_strlen($code, 'UTF-8'));
        $this->assertIsString($code);
    }

    /**
     * @return array
     */
    public function dataToTestGenerateCode(): array
    {
        return [
            [
                10, 100, 2000, 1000, 1, 3,
            ]
        ];
    }

    /**
     * @return void
     */
    public function testStringLenghtLessThanOne(): void
    {
        $this->expectException(InvaliidParametersException::class);
        $randomCodesGenerator = new RandomCodesGenerator();
        $randomCodesGenerator->generateCode(0);
    }

    /**     
     * @return void
     */
    public function testUniqueCodes(): void
    {
        $randomCodesGenerator = new RandomCodesGenerator();
        $codes = $randomCodesGenerator->generateCodes(1, 61, true);

        $uniqueCodes = array_unique($codes);

        $this->assertEquals($uniqueCodes, $codes);
    }

    /**
     *  @dataProvider dataToTestGenerateCodes
     *
     * @return void
     */
    public function testGenerateCodes(int $lenghtOfCode, int $numberOfCodes): void
    {
        $randomCodesGenerator = new RandomCodesGenerator();
        $codes = $randomCodesGenerator->generateCodes($lenghtOfCode, $numberOfCodes, true);

        $this->assertEquals($numberOfCodes, count($codes));

        foreach ($codes as $code) {
            $this->assertEquals($lenghtOfCode, mb_strlen($code, 'UTF-8'));
        }
    }

    /**
     * @return array
     */
    public function dataToTestGenerateCodes(): array
    {
        return [
            [10, 20],
            [100, 200],
            [200, 1000],
        ];
    }
}

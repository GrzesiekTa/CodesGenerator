<?php

class RandomCodesGenerator
{
    /**
     * default possible characters
     *
     * @var string
     */
    private $possibleCharacters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

    /**
     * method to generate code
     * 
     * @param integer $lenghtOfCode
     * 
     * @return string
     */
    public function generateCode(int $lenghtOfCode): string
    {
        $charactersLength = $this->getPossibleCharactersLength();
        $randomcode = '';

        for ($i = 0; $i < $lenghtOfCode; $i++) {
            $randomcode .= $this->possibleCharacters[mt_rand(0, $charactersLength - 1)];
        }

        return $randomcode;
    }

    /**
     * generate codes
     * 
     * @param integer $lenghtOfCode
     * @param integer $numberOfCodes
     * @param boolean $unique - control flag all codes in the table are to be unique - default false
     * 
     * @return array
     */
    public function generateCodes(int $lenghtOfCode, int $numberOfCodes, bool $unique = false): array
    {
        $codesArray = [];

        if ($unique) {
            $numberOfRandomCodes = 0;
            while ($numberOfRandomCodes < $numberOfCodes) {
                $code = $this->generateCode($lenghtOfCode);
                if (!in_array($code, $codesArray)) {
                    $codesArray[] = $code;
                    $numberOfRandomCodes++;
                }
            }
        } else {
            for ($i = 0; $i < $numberOfCodes; $i++) {
                $codesArray[] = $this->generateCode($lenghtOfCode);
            }
        }

        return $codesArray;
    }

    /**
     * method to set custom posible characters
     *
     * @param string $possibleCharacters
     * 
     * @return void
     */
    public function setPossibleCharacters(string $possibleCharacters): void
    {
        $this->possibleCharacters = $possibleCharacters;
    }

    /**
     * get possible characters length
     *
     * @return integer
     */
    private function getPossibleCharactersLength(): int
    {
        return mb_strlen($this->possibleCharacters, 'UTF-8');
    }
}

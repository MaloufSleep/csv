<?php

Class CSV
{
    /*
    * Parse CSV File
    *
    * Takes a CSV file and parses into an associative array.  uses
    * the header row to create keys for the array.
    *
    * @param string $path The path the CSV to parse
    *
    * @return array
    */
    public function parse($path): array
    {
        // read csv file into array
        $csv = array_map('str_getcsv', file($path));
        // combine keys to values for each row
        array_walk($csv, function (&$a) use ($csv) {
            $a = array_combine($csv[0], $a);
        });
        // remove header row
        array_shift($csv);
        return $csv;
    }

    /*
    * Write CSV
    *
    * Takes data and writes it out to CSV.  The is generic and used whenever
    * we need to generate a CSV to helix sleep.
    *
    * @param array $data Data to be encoded to CSV
    * @param string $fileName The file name to write the CSV out to
    *
    * @return void
    */
    public function write($data, $filename): void
    {
        $fp = fopen($filename, 'w');
        if ($fp === false) {
            throw new \Exception("Unabel to open ".$filename." to write csv.", 500);
        }
        foreach ($data as $dati) {
            if (!fputcsv($fp, (array)$dati)) {
                throw new \Exception("Unable to write to CSV file.", 500);
            }
        }
        fclose($fp);
    }
}
<?php

namespace App\Controllers\Tests;

use App\Database\DB;

class TestingController
{
    public function sayIt()
    {
        $texts = fopen(BASE_DIR . '/testing.csv', 'r');

        if ($texts) {
            while ($data = fgetcsv($texts)) {
                $array[] = $data;
            }
            fclose($texts);
        }
        echo '<table border="1">';
        foreach ($array as $value) {
            echo "<tr>";
            foreach ($value as $dt) {
                echo "<td> $dt </td>";
            }
            echo "</tr>";
        }
        // return (array) $res;
        echo '</table';
    }
}

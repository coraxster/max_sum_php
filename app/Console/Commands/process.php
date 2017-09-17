<?php
/**
 * Created by PhpStorm.
 * User: rockwith
 * Date: 17.09.17
 * Time: 15:32
 */
namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class process extends Command
{

    protected $signature = 'process {--sum=200} {--csv_file=products.csv}';
    protected $description = 'Find max sum with elements';

    public function handle()
    {
        storage_path($this->option('csv_file'));
        $file = Storage::disk('local')->get($this->option('csv_file'));

        $records = [];
        foreach (explode(PHP_EOL, $file) as $line => $string){
            $record = explode(',', $string) ?? false;
            if ( isset($record[1]) ){
                $record[1] = (int)$record[1];
                $records[] = $record;
            }
        }

        $coasts = [];
        foreach ($records as $record){
            $coasts[] = $record[1];
        }

        $coastIndexes = $this->dynamicMaxSumElements($coasts, $this->option('sum'));
        $total = 0;
        foreach ($coastIndexes as $coastIndex){
            echo($records[$coastIndex][0] . ' - ' . $records[$coastIndex][1] . PHP_EOL);
            $total = $total + $records[$coastIndex][1];
        }
        echo('Total: ' . $total . PHP_EOL);
    }




    protected function dynamicMaxSumElements($arr, $sum)
    {
        $sum_map = [ 0 => [] ];
        foreach ($arr as $i => $v) {
            for ($j = $sum-$v; $j >= 0; $j--) {
                if (isset($sum_map[$j])){
                    $sum_map[ $j + $v ] = array_merge($sum_map[$j], [$i]);
                }
            }
        }
        ksort($sum_map);
        return array_pop($sum_map);
    }



}
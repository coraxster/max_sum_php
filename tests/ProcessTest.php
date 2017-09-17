<?php

use \Illuminate\Support\Facades\Artisan as Artisan;


class ProcessTest extends TestCase
{



    public function testFullCase1()
    {
        $this->callWithExpect(
            'test_case1.csv',
            200,
            [
                'Яблоко - 100',
                'Помидор - 23',
                'Киви - 75',
                'Total: 198'
            ]
        );
    }



    protected function callWithExpect($filepath, $sum, $expects)
    {
        Artisan::call('process', [
            '--csv_file' => $filepath,
            '--sum' => $sum
        ]);
        $output = Artisan::output();

        foreach ($expects as $str){
            $this->assertContains(
                $str,
                $output
            );
        }

    }
}

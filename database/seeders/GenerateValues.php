<?php

namespace Database\Seeders;

use App\Models\Movie;
use App\Models\Producer;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class GenerateValues extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        $file_path = storage_path('app/movielist.csv');
        $rows = array_map("str_getcsv", file($file_path));
        $lines = $this->formatInfos($rows);
        $this->createRegisters($lines);
    }

    function createRegisters($lines)
    {
        if ( $lines ) {
            foreach ( $lines as $line ) {
                $movie = Movie::updateOrCreate(
                    [
                        'year' => $line['year'],
                        'title' => $line['title'],
                        'studio' => $line['studio']
                    ],
                    collect($line)
                        ->only('year', 'title', 'studio', 'winner')
                        ->toArray()
                );
                if ( $line['producers'] ) {
                    $producers = [];
                    foreach ( $line['producers'] as $producer ) {
                        $prod = Producer::updateOrCreate(
                            [
                                'name' => $producer 
                            ],
                            [
                                'name' => $producer
                            ]
                        );

                        if ( $prod )
                            $producers[] = $prod->id;
                    }
                    $movie->producers()->sync($producers);
                }

            }
        }
    }

    function formatInfos($rows)
    {   
        if ( $rows ) {
            $result = [];
            foreach ( $rows as $key =>  $line ) {
                if ( $key > 0 ) {
                    $text = '';
                    $infos = [];
                    if ( is_array( $line ) ) {
                        foreach ( $line as $op ) {
                            $text .= ';' . $op;
                        }
                    } else {
                        $text = $line;
                    }
    
                    $infos = explode(';', $text);
                    
                    
                    if ( $infos ) {
                        
                        $temp = [];
                        foreach ( $infos as $key => $info ) {
                            if ( $key > 0 ) {
                                if ( $info != '' ) 
                                    $temp[] = trim($info);
                            } 
                        }

                        $data = [
                            'year' => trim($temp[0]),
                            'title' => trim($temp[1]),
                            'studio' => trim($temp[2]),
                            'winner' => false
                        ];
                        unset($temp[0], $temp[1], $temp[2]);
                        foreach ( $temp as $rows ) {
                            foreach ( explode('and', $rows) as $row ) {
                                if ( $row != '' ) {
                                    if ( $row == 'yes' ) {
                                        $data['winner'] = true;
                                    } else {
                                        $data['producers'][] = trim($row);
                                    }
                                }
                                   
                            }
                        }
                        $result[] = $data;
                    }
                }
            }
            return $result;
        }
    }
}

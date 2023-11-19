<?php

namespace App\Services;

use App\Models\Producer;

class ProducerService
{
    public function consultMinAndMaxInternal()
    {
        $producers = Producer::orderBy('id', 'DESC')->get();
        $maxFirst = null;
        $maxFirstMoviesInfos = null;
        $maxFirstProducer = null;
        $maxSecond = null;
        $maxSecondProducer = null;
        $maxSecondMoviesInfos = null;
        $minFirst = null;
        $minFirstMoviesInfos = null;
        $minFirstProducer = null;
        $minSecond = null;
        $minSecondMoviesInfos = null;
        $minSecondProducer = null;


        if ( $producers ) {
            foreach ( $producers as $producer ) {
                $consult = $this->consultInterval($producer);
                if ( $consult ) {
                    if ( !$maxFirst || $consult['max'] > $maxFirst ) {
                        if ( !$maxFirst ) {
                            $maxSecond = $consult['max'];
                            $maxSecondMoviesInfos = [
                                'prev' => $consult['max_prev'],
                                'next' => $consult['max_next']
                            ];
                            $maxSecondProducer = $producer;
                        } else {
                            $maxSecond = $maxFirst;
                            $maxSecondMoviesInfos = $maxFirstMoviesInfos;
                            $maxSecondProducer = $maxFirstProducer;
                        }

                        $maxFirst = $consult['max'];
                        $maxFirstMoviesInfos = [
                            'prev' => $consult['max_prev'],
                            'next' => $consult['max_next']
                        ];
                        $maxFirstProducer = $producer;
                    }


                    if ( !$minFirst || $consult['min'] < $minFirst ) {
                        if ( !$minFirst ) {
                            $minSecond = $consult['min'];
                            $minSecondMoviesInfos = [
                                'prev' => $consult['min_prev'],
                                'next' => $consult['min_next']
                            ];
                            $minSecondProducer = $producer;
                        } else {
                            $minSecond = $minFirst;
                            $minSecondMoviesInfos = $minFirstMoviesInfos;
                            $minSecondProducer = $minFirstProducer;
                        }

                        $minFirst = $consult['min'];
                        $minFirstMoviesInfos = [
                            'prev' => $consult['min_prev'],
                            'next' => $consult['min_next']
                        ];
                        $minFirstProducer = $producer;
                    }
                }
            }
        } 

        return [
            'min' => [
                [
                    'producer' => $minFirstProducer->name,
                    'interval' => $minFirst,
                    'previousWin' => $minFirstMoviesInfos['prev']['year'],
                    'followingWin' => $minFirstMoviesInfos['next']['year']
                ],
                [
                    'producer' => $minSecondProducer->name,
                    'interval' => $minSecond,
                    'previousWin' => $minSecondMoviesInfos['prev']['year'],
                    'followingWin' => $minSecondMoviesInfos['next']['year']
                ]
            ],
            'max' => [
                [
                    'producer' => $maxFirstProducer->name,
                    'interval' => $maxFirst,
                    'previousWin' => $maxFirstMoviesInfos['prev']['year'],
                    'followingWin' => $maxFirstMoviesInfos['next']['year']
                ],
                [
                    'producer' => $maxSecondProducer->name,
                    'interval' => $maxSecond,
                    'previousWin' => $maxSecondMoviesInfos['prev']['year'],
                    'followingWin' => $maxSecondMoviesInfos['next']['year']
                ]
            ]
        ];
    }
    
    public function consultInterval(Producer $producer)
    {
        $movies = $producer->movies()
                    ->where('winner', true)
                    ->orderBy('year', 'ASC')
                    ->get();

        $movies = $producer->movies;
        
        if ( count($movies) < 2 )
            return false;

        $max = null;
        $min = null;
        $movieMaxNext = null;
        $movieMaxPrev = null;
        $movieMinPrev = null;
        $movieMinNext = null;

        foreach ( $movies as $index => $movie ) {
            if ( $index > 0 ) {
                $consultMax = $movie->year - $movies[$index-1]->year;
                if ( !$max || $consultMax > $max ) {
                    $movieMaxPrev = $movies[$index-1];
                    $movieMaxNext = $movie; 
                    $max = $consultMax;
                }
                
                $consultMin = $movie->year - $movies[$index-1]->year;
                if ( !$min || $consultMin < $min ) {
                    $movieMinPrev = $movies[$index-1];
                    $movieMinNext = $movie;
                    $min = $consultMin;
                } 
            }    
        }

        return [
            'min' => $min,
            'min_prev' => collect($movieMinPrev)->toArray(),
            'min_next' => collect($movieMinNext)->toArray(),
            'max' => $max,
            'max_prev' => collect($movieMaxPrev)->toArray(),
            'max_next' => collect($movieMaxNext)->toArray()
        ];
        
    }
}
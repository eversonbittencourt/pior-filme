<?php

namespace Tests\Unit;

use Tests\TestCase;

class TestProducers extends TestCase
{

    /**
     * Test consult Producers
     * 
     * @return void
     */
    public function testConsultProducers()
    {
        $response = $this->json('GET', '/api/producers');
        $response->assertStatus(200);
    }

    /**
     * Test premium interval query
     * 
     * @return void
     */
    public function consultLimitIntervals()
    {
        $response = $this->json('GET', '/api/producers/limit-interval');
        $response->assertStatus(200);
    }
    
}
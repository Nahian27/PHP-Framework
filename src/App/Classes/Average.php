<?php

namespace phpTest\src\App\Classes;

class Average
{
    private array $arr;

    /**
     * @param array $arr
     */
    public function setArr(array $arr): Average
    {
        $this->arr = $arr;
        return $this;
    }

    public function calculateWeightedAverage(): float
    {
        $totalWeight = $totalSum = 0;

        // Count frequency of each rating
        $frequency = array_count_values($this->arr);

        // Sum the weighted values
        foreach ($frequency as $rating => $count) {
            $totalSum += $rating * $count;  // Multiply rating by its frequency
            $totalWeight += $count;         // Sum of the frequencies (weights)
        }

        return $totalWeight > 0 ? $totalSum / $totalWeight : 0.0;  // Return weighted average
    }

    function calculateAverage(): float
    {
        $total = $count = 0;

        foreach ($this->arr as $rating) {
            $total += $rating;
            $count++;
        }

        return $count > 0 ? $total / $count : 0.0;
    }
}
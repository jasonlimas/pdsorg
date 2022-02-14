<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class QuotationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $qty = $this->faker->numberBetween(1, 10);
        $uPrice = $this->faker->numberBetween(50000, 2000000);
        $tax = 11;
        $tPrice = $uPrice * $qty;
        $tPriceTax = $tPrice + ($tPrice * $tax / 100);
        $items = [];
        $items[] = [
            'name' => $this->faker->name,
            'quantity' => $qty,
            'price' => $uPrice,
            'totalPrice' => $qty * $uPrice,
        ];

        $items[] = [
            'name' => $this->faker->name,
            'quantity' => $qty,
            'price' => $uPrice,
            'totalPrice' => $qty * $uPrice,
        ];

        return [
            'div' => $this->faker->randomElement(['A', 'B', 'C']),
            'sales_person' => $this->faker->name,
            'number' => $this->faker->randomNumber(5),
            'quote_date' => $this->faker->date(),
            'sender_id' => 1,
            'client_id' => $this->faker->numberBetween(1, 51),
            'items' => $items,
            'tax' => $tax,
            'terms_conditions' => [
                $this->faker->sentence(),
                $this->faker->sentence(),
                $this->faker->sentence()
            ],
            'amount' => $tPriceTax
        ];
    }
}

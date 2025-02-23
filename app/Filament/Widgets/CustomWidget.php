<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;

class CustomWidget extends ChartWidget
{
    protected static ?string $heading = 'Chart Of Registration';

    protected function getData(): array
    {

        return [
            'labels' =>
            ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
            'datasets' => [
                [
                    'label' => 'User Registrations',    
                    'backgroundColor' => ['#3366cc', '#dc3912', '#ff9900', '#109618', '#990099', '#3399ff', '#0099c6', '#9966cc', '#e64d22', '#f6bd0f', '#8085d6', '#3d6e9e'],

                    'data' => [25, 20, 15, 10, 5, 20, 15, 10, 5, 20, 15, 10],
                    'borderWidth' => 1,

                ],
            ],
        ];
    }
    protected function getType(): string
    {
        return 'pie';
    }
}

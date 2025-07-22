<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class PegawaiNotificationChart extends ChartWidget
{
    protected static ?string $heading = 'Pesan Notifikasi Pegawai Terkirim';
    protected static ?int $sort = 2;

    protected function getData(): array
    {
        $year = now()->year;

        $data = DB::table('notif_pegawais')
            ->selectRaw('MONTH(created_at) as bulan, COUNT(*) as total')
            ->whereYear('created_at', $year)
            ->groupByRaw('MONTH(created_at)')
            ->orderByRaw('MONTH(created_at)')
            ->pluck('total', 'bulan');

        $chartData = [];

        foreach (range(1, 12) as $bulan) {
            $chartData[] = $data[$bulan] ?? 0;
        }

        return [
            'datasets' => [
                [
                    'label' => 'Total Pesan Pegawai',
                    'data' => $chartData,
                    'backgroundColor' => '#16a34a',
                ],
            ],
            'labels' => [
                'Jan',
                'Feb',
                'Mar',
                'Apr',
                'Mei',
                'Jun',
                'Jul',
                'Agu',
                'Sep',
                'Okt',
                'Nov',
                'Des'
            ],
        ];
    }


    protected function getType(): string
    {
        return 'line';
    }
}

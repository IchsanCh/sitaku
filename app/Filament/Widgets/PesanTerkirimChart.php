<?php

namespace App\Filament\Widgets;

use App\Models\Pesan;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class PesanTerkirimChart extends ChartWidget
{
    protected static ?string $heading = 'Pesan Notifikasi Pemohon Terkirim';
    protected static ?int $sort = 1; // biar muncul di urutan atas dashboard

    protected function getData(): array
    {
        $data = Pesan::selectRaw('MONTH(created_at) as bulan, COUNT(*) as total')
            ->where('status', 'terkirim')
            ->whereYear('created_at', now()->year)
            ->groupBy(DB::raw('MONTH(created_at)'))
            ->pluck('total', 'bulan');

        // Bikin array 12 bulan
        $chartData = [];
        for ($i = 1; $i <= 12; $i++) {
            $chartData[] = $data[$i] ?? 0;
        }

        return [
            'datasets' => [
                [
                    'label' => 'Pesan Terkirim',
                    'data' => $chartData,
                    'borderColor' => '#10B981', // hijau
                    'fill' => false,
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

<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithTitle;

class ReportsExporter implements FromView, ShouldAutoSize, WithTitle
{
    private $viewName;
    private $viewData;

    public function __construct($viewName, $viewData)
    {
        $this->viewName = $viewName;
        $this->viewData = $viewData;

    }

    public function view(): View
    {
        return \view($this->viewName, $this->viewData);
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return 'Sheets';
    }
}

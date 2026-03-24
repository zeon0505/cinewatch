<?php

namespace App\Livewire\Admin\Reports;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\Report;
use Livewire\WithPagination;

class ListReports extends Component
{
    use WithPagination;

    public function resolve($id)
    {
        $report = Report::findOrFail($id);
        $report->update(['status' => 'resolved']);
    }

    public function delete($id)
    {
        Report::findOrFail($id)->delete();
    }

    #[Layout('components.layouts.dashboard')]
    public function render()
    {
        $reports = Report::with(['user', 'movie'])->latest()->paginate(10);
        return view('livewire.admin.reports.list-reports', compact('reports'));
    }
}

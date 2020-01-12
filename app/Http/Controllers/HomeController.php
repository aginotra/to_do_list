<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Charts\TaskActivity;
use Carbon\Carbon;

class HomeController extends Controller {

    /**
     * Paginate the authenticated user's tasks.
     *
     * @return \Illuminate\View\View
     */
    public function index() {
        // paginate the authorized user's tasks with 5 per page
        $tasks = Auth::user()
                ->tasks()
                ->orderBy('is_complete')
                ->orderByDesc('created_at')
                ->paginate(5);

        //Get Data for Chart
        $chart = $this->getChartData();
        // return task index view with paginated tasks
        return view('home', [
            'tasks' => $tasks,
            'chart' => $chart
        ]);
    }

    /**
     * Store a new incomplete task for the authenticated user.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request) {
        // validate the given request
        $data = $this->validate($request, [
            'title' => 'required|string|max:255',
        ]);

        // create a new incomplete task with the given title
        Auth::user()->tasks()->create([
            'title' => $data['title'],
            'is_complete' => false,
        ]);

        // flash a success message to the session
        session()->flash('status', 'Task Created!');

        // redirect to tasks index
        return redirect('/home');
    }

    /**
     * Mark the given task as complete and redirect to tasks index.
     *
     * @param \App\Models\Task $task
     * @return \Illuminate\Routing\Redirector
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(Request $request) {
        // mark the task as complete and save it
        $task = Task::find($request->taskId);
        $task->is_complete = true;
        $task->save();

        // flash a success message to the session
        session()->flash('status', 'Task Completed!');

        // redirect to tasks index
        return redirect('/home');
    }

    /**
     * 
     * Get the data for chart.
     */
    public function getChartData() {
        $fromDate = Carbon::now()->subMinutes(60);
        $toDate = Carbon::now();

        $chart = new TaskActivity;
        $chartData = Auth::user()->tasks()->where('is_complete', 0)->whereBetween('created_at', [$fromDate, $toDate])->get()->pluck('created_at')->toArray();
        $arr = [];
        foreach ($chartData as $k => $c) {
            $add = $k + 1;
            array_push($arr, $add);
        }
        $chart->labels($chartData);
        $chart->dataset('Pending task', 'line', $arr);
        return $chart;
    }

}

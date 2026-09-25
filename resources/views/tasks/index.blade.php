<!DOCTYPE html>
<html>

<head>

    <title>Task Manager Dashboard</title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="/css/style.css?v=3">

</head>

<body>

<div class="dashboard">

    <!-- HEADER -->

    <div class="dashboard-header">

        <div>
            <h1>Dashboard</h1>

            <p>
                Here's your task overview for today.
            </p>
        </div>

        <div class="date-box">
            <span>▣</span>

            {{ now()->format('M d, Y') }}
        </div>

    </div>


    <!-- STATISTICS -->

    @php

        $totalTasks = $tasks->count();

        $pendingTasks = $tasks->where('status', 'Pending')->count();

        $completedTasks = $tasks->where('status', 'Completed')->count();

        $overdueTasks = $tasks->filter(function ($task) {

            return $task->due_date
                && $task->status != 'Completed'
                && \Carbon\Carbon::parse($task->due_date)->isPast();

        })->count();

    @endphp


    <div class="stats">

        <!-- TOTAL -->

        <div class="stat-card">

            <div class="stat-icon green">
                ▤
            </div>

            <div>

                <p>Total Tasks</p>

                <h2>
                    {{ $totalTasks }}
                </h2>

            </div>

        </div>


        <!-- PENDING -->

        <div class="stat-card">

            <div class="stat-icon yellow">
                ◷
            </div>

            <div>

                <p>Pending</p>

                <h2>
                    {{ $pendingTasks }}
                </h2>

            </div>

        </div>


        <!-- COMPLETED -->

        <div class="stat-card">

            <div class="stat-icon green">
                ✓
            </div>

            <div>

                <p>Completed</p>

                <h2>
                    {{ $completedTasks }}
                </h2>

            </div>

        </div>


        <!-- OVERDUE -->

        <div class="stat-card">

            <div class="stat-icon red">
                !
            </div>

            <div>

                <p>Overdue</p>

                <h2>
                    {{ $overdueTasks }}
                </h2>

            </div>

        </div>

    </div>


    <!-- ADD TASK -->

    <div class="add-task-card">

        <form action="/tasks" method="POST">

            @csrf

            <div class="add-task-row">

                <input
                    type="text"
                    name="task_name"
                    placeholder="Enter a new task..."
                    required
                >

                <input
                    type="text"
                    name="description"
                    placeholder="Description"
                >

                <input
                    type="date"
                    name="due_date"
                >

                <select name="status">

                    <option value="Pending">
                        Pending
                    </option>

                    <option value="Ongoing">
                        Ongoing
                    </option>

                    <option value="Completed">
                        Completed
                    </option>

                </select>

                <button type="submit">
                    + Add Task
                </button>

            </div>

        </form>

    </div>


    <!-- TASKS HEADER -->

    <div class="tasks-heading">

        <h2>
            Today's Tasks
        </h2>

        <span>
            {{ $totalTasks }} tasks
        </span>

    </div>


    <!-- TASK LIST -->

    <div class="task-list">

        @foreach ($tasks as $task)

            @php

                $status = strtolower($task->status);

                $isOverdue =
                    $task->due_date &&
                    $status != 'completed' &&
                    \Carbon\Carbon::parse($task->due_date)->isPast();

            @endphp


            <div class="task-row">

                <!-- CHECKBOX -->

                <div class="task-check
                    @if($status == 'completed')
                        checked
                    @endif
                ">

                    @if($status == 'completed')
                        ✓
                    @endif

                </div>


                <!-- TASK INFORMATION -->

                <div class="task-info">

                    <h3
                        @if($status == 'completed')
                            class="completed-task"
                        @endif
                    >
                        {{ $task->task_name }}
                    </h3>

                    @if($task->description)

                        <p>
                            {{ $task->description }}
                        </p>

                    @endif

                </div>


                <!-- DATE -->

                <div class="task-date">

                    @if($task->due_date)

                        {{ \Carbon\Carbon::parse($task->due_date)->format('M d, Y') }}

                    @else

                        No date

                    @endif

                </div>


                <!-- STATUS -->

                <div class="task-status">

                    @if($isOverdue)

                        <span class="status-badge overdue">
                            Overdue
                        </span>

                    @elseif($status == 'completed')

                        <span class="status-badge completed">
                            Completed
                        </span>

                    @elseif($status == 'ongoing')

                        <span class="status-badge ongoing">
                            Ongoing
                        </span>

                    @else

                        <span class="status-badge pending">
                            Pending
                        </span>

                    @endif

                </div>


                <!-- ACTIONS -->

                <div class="task-actions">

                    <a
                        href="/tasks/{{ $task->id }}/edit"
                        class="edit-button"
                        title="Edit"
                    >
                        ✎
                    </a>


                    <form
                        action="/tasks/{{ $task->id }}"
                        method="POST"
                    >

                        @csrf

                        @method('DELETE')

                        <button
                            type="submit"
                            class="delete-button"
                            title="Delete"
                            onclick="return confirm('Are you sure you want to delete this task?')"
                        >
                            🗑
                        </button>

                    </form>

                </div>

            </div>

        @endforeach


        <!-- NO TASKS -->

        @if($tasks->count() == 0)

            <div class="empty-state">

                <h3>
                    No tasks yet
                </h3>

                <p>
                    Add your first task above.
                </p>

            </div>

        @endif

    </div>

</div>

</body>

</html>
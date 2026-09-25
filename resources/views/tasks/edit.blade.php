<!DOCTYPE html>
<html>

<head>

    <title>Edit Task</title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="/css/style.css?v=3">

</head>

<body>

<div class="edit-page">

    <!-- HEADER -->

    <div class="edit-page-header">

        <div>

            <h1>
                Edit Task
            </h1>

            <p>
                Update your task details.
            </p>

        </div>

        <a
            href="/tasks"
            class="back-button"
        >
            ← Back
        </a>

    </div>


    <!-- EDIT CARD -->

    <div class="edit-card">

        <form
            action="/tasks/{{ $task->id }}"
            method="POST"
        >

            @csrf

            @method('PUT')


            <!-- TASK NAME -->

            <div class="form-group">

                <label for="task_name">
                    Task Name
                </label>

                <input
                    type="text"
                    id="task_name"
                    name="task_name"
                    value="{{ $task->task_name }}"
                    placeholder="Task name"
                    required
                >

            </div>


            <!-- DESCRIPTION -->

            <div class="form-group">

                <label for="description">
                    Description
                </label>

                <input
                    type="text"
                    id="description"
                    name="description"
                    value="{{ $task->description }}"
                    placeholder="Description"
                >

            </div>


            <!-- STATUS -->

            <div class="form-group">

                <label for="status">
                    Status
                </label>

                <select
                    id="status"
                    name="status"
                >

                    <option
                        value="Pending"
                        {{ $task->status == 'Pending' ? 'selected' : '' }}
                    >
                        Pending
                    </option>

                    <option
                        value="Ongoing"
                        {{ $task->status == 'Ongoing' ? 'selected' : '' }}
                    >
                        Ongoing
                    </option>

                    <option
                        value="Completed"
                        {{ $task->status == 'Completed' ? 'selected' : '' }}
                    >
                        Completed
                    </option>

                </select>

            </div>


            <!-- DUE DATE -->

            <div class="form-group">

                <label for="due_date">
                    Due Date
                </label>

                <input
                    type="date"
                    id="due_date"
                    name="due_date"
                    value="{{ $task->due_date }}"
                >

            </div>


            <!-- BUTTONS -->

            <div class="edit-buttons">

                <a
                    href="/tasks"
                    class="cancel-button"
                >
                    Cancel
                </a>

                <button
                    type="submit"
                    class="update-button"
                >
                    ✓ Update Task
                </button>

            </div>

        </form>

    </div>

</div>

</body>

</html>
<x-layout>
    <x-slot:heading>
        Edit Task : {{$task->title}}
    </x-slot:heading>
    <form method="POST" action="/admin/tasks/{{$task->id}}">
        @csrf
        @method('PATCH')
        <x-form-field>
            <x-form-label for="title">Title</x-form-label>
            <x-form-input name="title" type="text" id="title" value="{{$task->title}}" placeholder="Read book" required/>
            <x-form-error name="title"/>
        </x-form-field>
        <x-form-field>
            <x-form-label for="description">Description</x-form-label>
{{--            <x-form-input name="description" type="text" id="description" placeholder="Read 10 pages a day" />--}}
            <textarea class="form-control" name="description" id="description">{{$task->description}}</textarea>
            <x-form-error name="description"/>
        </x-form-field>
        <x-form-field>
            <x-form-label for="status">Status</x-form-label>
            <select class="custom-select" id="status" name="status" required>
                <option value="toDo" {{ $task->status == 'toDo' ? 'selected' : '' }}>toDo</option>
                <option value="inProgress" {{ $task->status == 'inProgress' ? 'selected' : '' }}>inProgress</option>
                <option value="completed" {{ $task->status == 'completed' ? 'selected' : '' }}>completed</option>
            </select>
            <x-form-error name="status"/>
        </x-form-field>
        <x-form-field>
            <x-form-label for="completionDate">Completion Date</x-form-label>
            <x-form-input name="completionDate" type="date" id="completionDate" placeholder="pick a date" value="{{ $task->completionDate ? \Carbon\Carbon::parse($task->completionDate)->format('Y-m-d') : '' }}"/>
            <x-form-error name="completionDate"/>
        </x-form-field>
        <hr>
        <x-form-button>Update</x-form-button>
        <x-form-button type="button" class="btn btn-secondary" >Cancel</x-form-button>
    </form>

</x-layout>

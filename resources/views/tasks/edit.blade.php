<x-layout>
    <x-slot:heading>
        Edit Task : {{$task->title}}
    </x-slot:heading>
    <form method="POST" action="{{route('tasks.update' , $task->id)}}">
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
                @foreach (\App\EnumsTasksStatus::cases() as $status)
                    <option value="{{ $status->value }}" {{ old('status') === $status->value ? 'selected' : '' }}>
                        {{ ucfirst($status->name) }}
                    </option>
                @endforeach
            </select>
            <x-form-error name="status"/>
        </x-form-field>
        <x-form-field>
            <x-form-label for="completionDate">Completion Date</x-form-label>
            @if(isJalali())
                <x-form-input name="completionDate" type="text" data-jdp id="completionDate"  value="{{  formatDateForDisplay($task->completionDate)  }}" placeholder="Click on me! choose a date  -  1403/03/10" />

            @else
                <x-form-input name="completionDate" type="date" id="completionDate" value="{{ \Carbon\Carbon::parse($task->completionDate)->format('Y-m-d') }}" />
            @endif

{{--            <x-form-input name="completionDate" type="date" id="completionDate" placeholder="pick a date" value="{{ $task->completionDate ? \Carbon\Carbon::parse($task->completionDate)->format('Y-m-d') : '' }}"/>--}}
            <x-form-error name="completionDate"/>
        </x-form-field>
        <hr>
        <x-form-button>Update</x-form-button>
        <a class="btn-user btn-block btn btn-secondary" href="/admin/tasks">Cancel</a>
    </form>

</x-layout>

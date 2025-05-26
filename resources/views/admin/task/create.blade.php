<x-layout>
    <x-slot:heading>
        Create New Task
    </x-slot:heading>
    <form method="POST" action="{{route('tasks.store')}}">
        @csrf
        <x-form-field>
            <x-form-label for="title">Title</x-form-label>
            <x-form-input name="title" type="text" id="title" placeholder="Read book" required/>
            <x-form-error name="title"/>
        </x-form-field>
        <x-form-field>
            <x-form-label for="description">Description</x-form-label>
{{--            <x-form-input name="description" type="text" id="description" placeholder="Read 10 pages a day" />--}}
            <textarea class="form-control" name="description" id="description"></textarea>
            <x-form-error name="description"/>
        </x-form-field>
        <x-form-field>
            <x-form-label for="status">Status</x-form-label>
            <select class="custom-select" id="status" name="status" required>
                <option selected>Choose...</option>
                <option value="toDo">toDo</option>
                <option value="inProgress">inProgress</option>
                <option value="completed">completed</option>
            </select>
            <x-form-error name="status"/>
        </x-form-field>
        <x-form-field>
            <x-form-label for="completionDate">Completion Date</x-form-label>
            <x-form-input name="completionDate" type="date" id="completionDate" placeholder="pick a date" />
            <x-form-error name="completionDate"/>
        </x-form-field>
        <hr>
        <x-form-button>Save</x-form-button>
        <x-form-button type="button" class="btn btn-secondary" >Cancel</x-form-button>
    </form>

</x-layout>

<x-layout>
    <x-slot:heading>
        Tasks
    </x-slot:heading>
    <!-- Begin Page Content -->

    <div class="container-fluid">
        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header d-sm-flex  py-3 align-items-center justify-content-between mb-4">
                <h6 class="m-0 font-weight-bold text-primary">Task list</h6>
                <a href="/admin/tasks/create" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-file-alt fa-sm text-white-50"></i> Create new task</a>
            </div>
            <div class="card-body">
                <div class="table-responsive" style="overflow-x: inherit;">

                        <form method="GET" action="{{ route('tasks.index') }}" class="">
                            <div class="row mb-4">
                            <div class="col-sm-12 col-md-1">
                                <div class="dataTables_length" id="dataTable_length">
                                        <select name="perPage" aria-controls="dataTable" class="custom-select custom-select-sm form-control form-control-sm">
                                            @foreach (\App\EnumPerPage::cases() as $num)
                                                <option value="{{ $num->value }}" {{ request('status') === $num->value ? 'selected' : '' }}>
                                                    {{ ucfirst($num->value) }}
                                                </option>
                                            @endforeach
                                        </select>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-10">
                                <div id="dataTable_filter" class="dataTables_filter">
                                    <input type="search" class="form-control form-control-sm col-md-2" name="title" placeholder="title" aria-controls="dataTable" style="display: inline" value="{{ request('title') }}">
                                    <select name="status" aria-controls="dataTable" class="col-md-2 custom-select custom-select-sm form-control form-control-sm" style="display: inline">
                                        <option value="">All Statuses</option>
                                            @foreach (\App\EnumsTasksStatus::cases() as $status)
                                                <option value="{{ $status->value }}" {{ request('status') === $status->value ? 'selected' : '' }}>
                                                    {{ ucfirst($status->name) }}
                                                </option>
                                            @endforeach
                                    </select>
                                    @if(isJalali())
                                        <label>From : </label> <input type="text"  data-jdp name="dateFrom" value="{{ old('dateFrom', $dateFrom) }}"  class="date col-md-2  form-control form-control-sm" style="display: inline">
                                        <label>To : </label>  <input type="text"  data-jdp name="dateTo" value="{{ old('dateTo', $dateTo) }}" class="date col-md-2  form-control form-control-sm" style="display: inline">
                                    @else
                                        <label>From : </label> <input type="date"  name="dateFrom" value="{{ old('dateFrom', $dateFrom) }}"  class="date col-md-2  form-control form-control-sm" style="display: inline">
                                        <label>To : </label>  <input type="date"  name="dateTo" value="{{ old('dateTo', $dateTo) }}" class="date col-md-2  form-control form-control-sm" style="display: inline">
                                    @endif

                                    <input type="submit" name="search" value="search" class="btn btn-primary col-md-1 form-control form-control-sm" style="display: inline"/>
                                </div>
                            </div>
                            </div>
                        </form>
                    @if ($tasks->count())
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                        <tr>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Status</th>
                            <th>Completion Date</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tfoot>
                        <tr>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Status</th>
                            <th>Completion Date</th>
                            <th></th>
                        </tr>
                        </tfoot>
                        <tbody>
                        @foreach($tasks as $task)
                            <tr>
                                <td>{{$task->title}}</td>
                                <td>{{$task->description}}</td>
                                <td>{{$task->status}}</td>
                                <td>{{ formatDateForDisplay($task->completionDate) }}</td>
                                <td>
                                    <a class="btn btn-primary btn-circle" href="/admin/tasks/{{$task->id}}/edit" role="button"><i class="fa fa-edit fa-sm fa-fw mr-2 text-white-50" aria-hidden="true"></i></a>
                                    <a class="btn btn-danger btn-circle" href="#" role="button" data-toggle="modal" data-target="#deleteModal{{$task->id}}"><i class="fa fa-trash fa-sm fa-fw mr-2 text-white-50" aria-hidden="true"></i></a>
                                </td>
                            </tr>
                            <div class="modal fade" id="deleteModal{{$task->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                                 aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Ready to Delete ?</h5>
                                            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">×</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">Select "Delete" below if you are ready to remove your task  ({{$task->title}}).</div>
                                        <div class="modal-footer">
                                            <form action="/admin/tasks/{{$task->id}}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                                                <input type="submit"  class="btn btn-danger" value="Delete" />
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                        </tbody>
                    </table>
                    <div class="d-flex mt-4">
                        {{$tasks->links()}}
                    </div>
                    @else
                        <div class="text-center text-gray-600 mt-4">
                            No Data!
                        </div>
                    @endif
                </div>

            </div>
        </div>

    </div>
    <!-- /.container-fluid -->
</x-layout>

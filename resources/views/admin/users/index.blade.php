<x-layout>
    <x-slot:heading>
        Users
    </x-slot:heading>
    <!-- Begin Page Content -->

    <div class="container-fluid">
        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header d-sm-flex  py-3 align-items-center justify-content-between mb-4">
                <h6 class="m-0 font-weight-bold text-primary">Task list</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive" style="overflow-x: inherit;">
                    @if ($users->count())
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                        <tr>
                            <th>firstName</th>
                            <th>lastName</th>
                            <th>email</th>
                        </tr>
                        </thead>
                        <tfoot>
                        <tr>
                            <th>firstName</th>
                            <th>lastName</th>
                            <th>email</th>
                        </tr>
                        </tfoot>
                        <tbody>
                        @foreach($users as $user)
                            <tr>
                                <td>{{$user->firstName}}</td>
                                <td>{{$user->lastName}}</td>
                                <td>{{$user->email}}</td>
                            </tr>
                        @endforeach

                        </tbody>
                    </table>
                    <div class="d-flex mt-4">
{{--
                        {{$users->links()}}
--}}
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

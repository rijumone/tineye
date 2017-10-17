@extends('layouts.app')

@section('content')
    <!-- Create Task Form... -->

    <!-- Current Tasks -->
    @if (count($profiles) > 0)
        <div class="panel panel-default">
            <div class="panel-heading">
                All profiles
            </div>

            <div class="panel-body">
                <table class="table table-striped">

                    <!-- Table Headings -->
                    <thead>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Age</th>
                        <th>City</th>
                        <th>&nbsp;</th>
                    </thead>

                    <!-- Table Body -->
                    <tbody>
                        @foreach ($profiles as $profile)
                            <tr>
                                <!-- First Name -->
                                <td class="table-text">
                                    <div>{{ $profile->first_name }}</div>
                                </td>
                                <td class="table-text">
                                    <div>{{ $profile->last_name }}</div>
                                </td>
                                </td>
                                <td class="table-text">
                                    <div>{{ $profile->age }}</div>
                                </td>
                                <td class="table-text">
                                    <div>{{ $cities[$profile->city_id] }}</div>
                                </td>

                                <td>
                                    <!-- TODO: Delete Button -->
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif
@endsection
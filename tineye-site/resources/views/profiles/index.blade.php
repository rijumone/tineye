@extends('layouts.app')

@section('content')
    <!-- Create Task Form... -->

    <!-- Current Tasks -->
    @if (count($profiles) > 0)
        <div class="panel panel-default">
            <div class="panel-heading">
                All profiles
            </div>
            <!-- Trigger the modal with a button -->
            <!-- <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#thumb_modal">Open Modal</button> -->

            <!-- Modal -->
            <div id="thumb_modal" class="modal fade" role="dialog">
              <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Modal Header</h4>
                  </div>
                  <div class="modal-body text-center">
                    <img id="thumb_image" src="">
                    <p><a class="btn btn-default btn-primary" id="detail_anchor" href="javascript:void(0)">Tap to go to details page</a></p>
                  </div>

                  <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  </div>
                </div>

              </div>
            </div>
            <div class="panel-body">
                <table class="table table-striped">

                    <!-- Table Headings -->
                    <thead>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Age</th>
                        <th>Sex</th>
                        <th>City</th>
                        <th>&nbsp;</th>
                    </thead>

                    <!-- Table Body -->
                    <tbody>
                        @foreach ($profiles as $profile)
                            <tr class="profile_row" data-profile_id="{{ $profile->id }}" data-profile_city="{{ $cities[$profile->city_id] }}" data-profile_data="{{ $profile->first_name }} {{ $profile->last_name }}, {{ $profile->age }}" data-detail_anchor="{{ route('detail', ['id' => $profile->id]) }}" >
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
                                    <div>{{ $profile->sex }}</div>
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

<script type="text/javascript">

    $("tr.profile_row").click(function(){
        $("img#thumb_image").attr("src","{{ env('IMAGE_CDN') }}"+cities_map[$(this).data('profile_city')]+"/"+$(this).data('profile_id')+"/thumb.png");
        $(".modal-title").html($(this).data('profile_data'));
        $("a#detail_anchor").attr("href", $(this).data('detail_anchor'));
        $("#thumb_modal").modal();
    })
</script>
@endsection
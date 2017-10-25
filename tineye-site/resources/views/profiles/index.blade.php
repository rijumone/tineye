@extends('layouts.app')

@include('layouts.nav')
@section('content')
<!-- Create Task Form... -->

<!-- Current Tasks -->

<div class="panel panel-default">
    <div class="panel-heading">
        All profiles
    </div>
    <!-- Trigger the modal with a button -->
    <!-- <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#thumb_modal">Open Modal</button> -->
    <form class="form-inline">
        Showing <span>5</span> result<span>s</span> from 
        <select name="sex" class="form-control">
            <option value="0">both</option>    
            <option value="man">men</option>    
            <option value="woman" selected>women</option>    
        </select> 
        named like 
        <input type="text" class="form-control" name="name" placeholder="Name" value="Sneha" /> 
        in 
        <select name="city" class="form-control">
            <option value="Delhi" selected>New Delhi</option>    
            @foreach (json_decode($cities_map, TRUE) as $city => $value)
            <option value="{{$city}}">{{$city}}</option>    
            @endforeach
        </select> 
        and surrounding areas, aged between 
        <input type="number" class="form-control" name="age_from" placeholder="Age from" value="18" /> 
        &amp; 
        <input type="number" class="form-control" name="age_to" placeholder="Age to" value="19" />
        <input type="submit" class="btn-primary form-control" name="" value="Search">
    </form>
    @if (count($profiles) > 0)
    <div class="panel-body table-responsive">
        <table class="table table-striped">

            <!-- Table Headings -->
            <thead>
            </thead>
            <!-- Table Body -->
            <tbody>
            <!-- <tr><td><input type="submit" name="" class="btn-primary" value="Submit" /></td></tr> -->
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
    @endif

</div>

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
                <br/>
                <p><a class="btn btn-default btn-primary" id="detail_anchor" href="javascript:void(0)">Tap to go to details page</a></p>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>

<script type="text/javascript">

    $("tr.profile_row").click(function () {
        $("img#thumb_image").attr("src", "{{ env('IMAGE_CDN') }}" + cities_map[$(this).data('profile_city')] + "/" + $(this).data('profile_id') + "/thumb.png");
        $(".modal-title").html($(this).data('profile_data'));
        $("a#detail_anchor").attr("href", $(this).data('detail_anchor'));
        $("#thumb_modal").modal();
    })
</script>
@endsection
@if(Session::has('successMsg') OR Session::has('errorMsg'))
    @if(Session::has('errorMsg'))
        <div data-alert class="alert alert-danger">
            {!!  Session::get('errorMsg') !!}
        </div>
    @else
        <div data-alert class="alert alert-success">
            {!! Session::get('successMsg') !!}
        </div>
    @endif
@endif
@if($errors->any())
    <div data-alert class="alert alert-danger">
        <h5 class="errorheader">Errors found:</h5>
        <ul class="square errorpoints">
            {!! implode('',$errors->all('<li>:message</li>')) !!}
        </ul>
    </div>
@endif